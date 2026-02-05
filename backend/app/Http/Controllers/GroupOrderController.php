<?php

namespace App\Http\Controllers;

use App\Models\{
    GroupOrder,
    GroupOrderMember,
    GroupOrderItem,
    GroupOrderSettlement,
    Book,
    Order,
    OrderItem,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\GroupOrderPayment;
use App\Mail\GroupPaymentLinkMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class GroupOrderController extends Controller
{
    /**
     * Tạo phòng (BẮT BUỘC JWT)
     * - Set user.is_group_cart = true
     */
    public function store(Request $req)
    {
        $user = $req->user();

        $req->validate([
            'allow_guest' => 'boolean',
            'expires_hours' => 'nullable|integer|min:1|max:72',
            'shipping_rule' => 'nullable|in:equal,by_value,owner_only'
        ]);

        $group = GroupOrder::create([
            'owner_user_id' => $user->id,
            'join_token' => Str::ulid(),
            'allow_guest' => (bool) $req->boolean('allow_guest'),
            'shipping_rule' => $req->input('shipping_rule', 'equal'),
            'expires_at' => now()->addHours($req->input('expires_hours', 6)),
        ]);

        $group->members()->create([
            'user_id' => $user->id,
            'display_name' => $user->name,
            'role' => 'owner',
        ]);

        // ✅ Đánh dấu user đang ở group cart
        $user->forceFill(['is_group_cart' => true])->save();

        return response()->json([
            'join_url' => $group->join_url,
            'group' => $group,
        ], 201);
    }

    /**
     * Join bằng link (BẮT BUỘC JWT)
     * - Set user.is_group_cart = true
     */
    public function join(Request $req, string $token)
    {
        $user = $req->user();

        $group = GroupOrder::open()
            ->where('join_token', $token)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->firstOrFail();

        $member = $group->members()->firstOrCreate(
            ['user_id' => $user->id],
            ['display_name' => $user->name, 'role' => 'member']
        );

        $user->forceFill(['is_group_cart' => true])->save();

        return response()->json([
            'group_id' => $group->id,
            'member_id' => $member->id,
            'status' => $group->status
        ]);
    }

    /**
     * Thêm món (snapshot giá) — KHÔNG nhận member_id, tự map theo JWT đã join
     */
    public function addItem(Request $req, string $token)
    {
        $data = $req->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $group = GroupOrder::open()->where('join_token', $token)->firstOrFail();

        $member = $group->members()->where('user_id', $req->user()->id)->first();
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chưa join group này'
            ], 403);
        }

        $book = Book::select('id', 'price', 'discount_price', 'stock', 'is_physical')->findOrFail($data['book_id']);
        $price = $book->discount_price ?? $book->price;

        $existingItem = $group->items()
            ->where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->first();

        $totalQuantity = $data['quantity'];
        if ($existingItem) {
            $totalQuantity = $existingItem->quantity + $data['quantity'];
        }

        if ($book->is_physical && $book->stock < $totalQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Hết hàng hoặc không đủ tồn'
            ], 400);
        }

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $totalQuantity,
                'price_snapshot' => $price,
            ]);
            $item = $existingItem;
        } else {
            $item = $group->items()->create([
                'member_id' => $member->id,
                'book_id' => $book->id,
                'quantity' => $data['quantity'],
                'price_snapshot' => $price,
            ]);
        }

        return response()->json([
            'success' => true,
            'item' => $item->load('book:id,title,cover_image')
        ], 201);
    }

    public function removeItem(Request $req, string $token, int $id)
    {
        $group = $this->findGroupByToken($token, 'open');

        if ($group->expires_at && now()->greaterThan($group->expires_at)) {
            return response()->json(['success'=>false,'message'=>'Group đã hết hạn'], 409);
        }

        $user = $req->user();
        if (!$user) return response()->json(['success'=>false,'message'=>'Chưa đăng nhập'], 401);

        $isMember = $group->members()->where('user_id', $user->id)->exists();
        if (!$isMember) return response()->json(['success'=>false,'message'=>'Bạn không thuộc group này'], 403);

        $item = $group->items()->with('member')->findOrFail($id);

        if (!empty($item->status) && $item->status !== 'pending') {
            return response()->json(['success'=>false,'message'=>'Item không ở trạng thái pending'], 409);
        }

        $item->delete();
        return response()->json(['success'=>true,'message'=>'Đã xoá sản phẩm khỏi giỏ nhóm']);
    }

    /**
     * Khoá phòng (owner)
     */
    public function lock(Request $req, string $token)
    {
        $group = GroupOrder::open()
            ->where('join_token', $token)
            ->firstOrFail();

        DB::transaction(function () use ($group) {
            $group->update(['status' => 'locked']);
        });

        return response()->json([
            'success'   => true,
            'message'   => 'Phòng đã được khoá thành công',
            'group_id'  => $group->id,
            'status'    => 'locked',
            'locked_at' => now()->format('d/m/Y H:i:s'),
            'members'   => [],
            'items'     => [],
            'by_member' => [],
            'total'     => 0,
        ]);
    }

    /**
     * Checkout (owner) - chỉ hàm này tạo Order
     */
    public function checkout(Request $req, string $token)
    {
        $req->validate([
            'payment'        => 'nullable|in:cod,bank_transfer,credit_card',
            'note'           => 'nullable|string|max:500',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'sonha'          => 'nullable|string|max:50',
            'street'         => 'nullable|string|max:100',
            'ward_id'        => 'nullable|integer',
            'ward_name'      => 'nullable|string|max:100',
            'district_id'    => 'nullable|integer',
            'district_name'  => 'nullable|string|max:100',
        ]);

        $group = $this->findGroupByToken($token); // không ép status ở đây

        // Idempotent trước: đã có order_id -> trả về
        if ($group->order_id && $exist = Order::find($group->order_id)) {
            return response()->json([
                'success' => true,
                'message' => 'Đơn đã được tạo trước đó',
                'data'    => ['order_id' => $exist->id, 'order_code' => $exist->order_code]
            ]);
        }
        // Trường hợp hi hữu: status checked_out nhưng chưa set order_id
        if ($group->status === 'checked_out' && ! $group->order_id) {
            if ($exist = Order::where('group_order_id', $group->id)->latest('id')->first()) {
                $group->update(['order_id' => $exist->id]);
                return response()->json([
                    'success' => true,
                    'message' => 'Đơn đã được tạo trước đó',
                    'data'    => ['order_id' => $exist->id, 'order_code' => $exist->order_code]
                ]);
            }
        }

        // Chặn trạng thái không hợp lệ
        if (! in_array($group->status, ['open','locked'])) {
            return response()->json([
                'success' => false,
                'code'    => 'group_not_active',
                'message' => "Phòng đang ở trạng thái '{$group->status}', không thể checkout."
            ], 409);
        }

        // Rỗng item
        $group->load(['items.book','owner','members','settlements']);
        if ($group->items->isEmpty()) {
            return response()->json(['success'=>false,'code'=>'empty','message'=>'Phòng trống'], 400);
        }

        // Nếu không COD -> yêu cầu all paid
        [$allPaid, $unpaidMembers] = $this->checkAllMembersPaid($group->id);
        $isCOD = $req->input('payment') === Order::PAYMENT_COD;
        if (! $isCOD && ! $allPaid) {
            return response()->json([
                'success' => false,
                'code'    => 'payments_pending',
                'message' => 'Chưa đủ thanh toán',
                'unpaid_members' => $unpaidMembers
            ], 409);
        }

        // Build address payload
        $addr = [
            'payment'       => $req->input('payment'),
            'note'          => $req->input('note'),
            'phone'         => $req->input('phone'),
            'address'       => $req->input('address'),
            'sonha'         => $req->input('sonha'),
            'street'        => $req->input('street'),
            'ward_id'       => $req->input('ward_id'),
            'ward_name'     => $req->input('ward_name'),
            'district_id'   => $req->input('district_id'),
            'district_name' => $req->input('district_name'),
        ];

        // Tạo order 1 lần
        $order = $this->finalizeGroupOrderOnce($group->id, $addr);

        return response()->json([
            'success' => true,
            'message' => 'Checkout thành công',
            'data'    => [
                'order_id'   => $order->id,
                'order_code' => $order->order_code,
                'total'      => $order->total_price,
            ]
        ]);
    }

    private function checkAllMembersPaid(int $groupId): array
    {
        $group = GroupOrder::with(['settlements','members'])->findOrFail($groupId);
        $pays  = GroupOrderPayment::where('group_order_id', $groupId)->get()->groupBy('member_id');

        $unpaid = [];
        foreach ($group->settlements as $s) {
            $due = (int) ($s->amount_due ?? 0);
            if ($due <= 0) continue;

            $forMember = $pays->get($s->member_id) ?? collect();
            $hasPaid   = $forMember->contains(fn($p) => $p->status === 'paid');

            if (!$hasPaid) {
                $m = $group->members->firstWhere('id', $s->member_id);
                $unpaid[] = [
                    'member_id'  => $s->member_id,
                    'name'       => optional($m)->display_name,
                    'amount_due' => $due,
                ];
            }
        }
        return [count($unpaid) === 0, $unpaid];
    }

    private function finalizeGroupOrderOnce(int $groupId, array $addr = []): Order
    {
        return DB::transaction(function () use ($groupId, $addr) {
            $group = GroupOrder::whereKey($groupId)
                ->lockForUpdate()
                ->with(['items.book','owner'])
                ->firstOrFail();

            if ($group->order_id && $exist = Order::find($group->order_id)) return $exist;
            if ($exist = Order::where('group_order_id', $groupId)->first()) {
                $group->update(['order_id' => $exist->id, 'status' => 'checked_out']);
                return $exist;
            }

            $items    = $group->items;
            $owner    = $group->owner;
            $subtotal = $items->sum(fn($i) => $i->quantity * $i->price_snapshot);

            $totalSettled = GroupOrderSettlement::where('group_order_id', $groupId)->sum('amount_due');
            $shipping     = max(0, $totalSettled - $subtotal);
            $total        = $subtotal + $shipping;

            $fullAddress = $addr['address']
                ?? trim(collect([
                    isset($addr['sonha']) ? 'Số '.$addr['sonha'] : null,
                    $addr['street'] ?? null,
                    $addr['ward_name'] ?? null,
                    $addr['district_name'] ?? null,
                ])->filter()->implode(', '));

            $order = Order::create([
                'user_id'        => $owner->id,
                'group_order_id' => $group->id,
                'order_code'     => $this->genOrderCode(),
                'payment'        => $addr['payment'] ?? Order::PAYMENT_COD,
                'status'         => Order::STATUS_PENDING,
                'price'          => $subtotal,
                'shipping_fee'   => $shipping,
                'total_price'    => $total,
                'note'           => $addr['note'] ?? null,
                'phone'          => $addr['phone'] ?? ($owner->phone ?? ''),
                'sonha'          => $addr['sonha'] ?? null,
                'street'         => $addr['street'] ?? null,
                'ward_id'        => $addr['ward_id'] ?? null,
                'ward_name'      => $addr['ward_name'] ?? null,
                'district_id'    => $addr['district_id'] ?? null,
                'district_name'  => $addr['district_name'] ?? null,
                'address'        => $fullAddress ?: ($owner->address ?? ''),
            ]);

            foreach ($items as $i) {
                $book = $i->book;
                if (($book->is_physical ?? false) && $book->stock < $i->quantity) {
                    throw new \RuntimeException("Kho không đủ cho {$book->title}");
                }
                if (($book->is_physical ?? false)) $book->decrement('stock', $i->quantity);

                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id'  => $i->book_id,
                    'quantity' => $i->quantity,
                    'price'    => $i->price_snapshot,
                ]);
            }

            $group->update([
                'status'       => 'checked_out',
                'order_id'     => $order->id,
                'confirmed_at' => now(),
            ]);

            return $order;
        });
    }

    /**
     * Xem phòng (public)
     */
    public function show(Request $req, string $token)
    {
        $group = GroupOrder::where('join_token', $token)
            ->with([
                'members.user:id,name',
                'items.book' => function ($q) {
                    $q->select('id', 'title', 'price', 'cover_image');
                },
            ])
            ->firstOrFail();

        $byMember = $group->items->groupBy('member_id')->map(function ($list) {
            return [
                'subtotal' => $list->sum(fn($i) => $i->quantity * $i->price_snapshot),
                'items' => $list->map(fn($i) => [
                    'id'          => $i->id,
                    'book_id'     => $i->book_id,
                    'title'       => $i->book->title,
                    'cover_image' => $i->book->cover_image,
                    'qty'         => $i->quantity,
                    'price'       => $i->price_snapshot,
                ])->values(),
            ];
        });

        $total = $group->items->sum(fn($i) => $i->quantity * $i->price_snapshot);

        return response()->json([
            'status'     => $group->status,
            'expires_at' => $group->expires_at,
            'join_url'   => $group->join_url,
            'members'    => $group->members->map(fn($m) => [
                'id'      => $m->id,
                'name'    => $m->display_name,
                'role'    => $m->role,
                'user_id' => $m->user_id,
            ])->values(),
            'by_member' => $byMember,
            'total'     => $total,
        ]);
    }

    /**
     * Kick thành viên khỏi phòng (chỉ owner)
     */
    private function findGroupByToken(string $rawToken, ?string $requireStatus = null): GroupOrder
    {
        $token = trim(urldecode($rawToken));
        $tokenUp = strtoupper($token);

        $q = GroupOrder::query()
            ->where(function ($qq) use ($token, $tokenUp) {
                $qq->where('join_token', $token)
                   ->orWhere('join_token', $tokenUp)
                   ->orWhereRaw('LOWER(join_token) = LOWER(?)', [$token]);
            });

        if ($requireStatus) {
            $q->where('status', $requireStatus);
        }

        $group = $q->first();

        if (!$group) {
            \Log::warning('Group not found by token', [
                'raw'     => $rawToken,
                'trim'    => $token,
                'upper'   => $tokenUp,
                'env'     => config('app.env'),
                'db'      => config('database.connections.'.config('database.default').'.database'),
            ]);
            abort(404, 'Group not found by token');
        }

        return $group;
    }

    public function kick(Request $req, string $token, $userId)
    {
        $rawToken = $token;
        $norm = trim(urldecode($rawToken));
        $upper = strtoupper($norm);
        $lower = strtolower($norm);

        $exact = GroupOrder::where('join_token', $norm)->first();
        $exactUpper = GroupOrder::where('join_token', $upper)->first();
        $loose = GroupOrder::whereRaw('LOWER(join_token) = ?', [$lower])->first();

        $dbName = config('database.connections.'.config('database.default').'.database');
        $env    = config('app.env');

        $group = $exact ?: $exactUpper ?: $loose;

        if (!$group) {
            return response()->json([
                'code'    => 'group_not_found',
                'message' => 'Không tìm thấy phòng theo token.',
                'debug'   => [
                    'env'        => $env,
                    'db'         => $dbName,
                    'token_raw'  => $rawToken,
                    'token_norm' => $norm,
                    'match'      => [
                        'exact'       => (bool) $exact,
                        'exactUpper'  => (bool) $exactUpper,
                        'looseLower'  => (bool) $loose,
                    ],
                ],
            ], 404);
        }

        if ($group->status !== 'open') {
            return response()->json([
                'code'    => 'group_not_open',
                'message' => 'Phòng không ở trạng thái open.',
                'status'  => $group->status,
                'debug'   => ['group_id' => $group->id],
            ], 409);
        }

        $actorUser = $req->user();
        if (!$actorUser) {
            return response()->json(['code' => 'unauth', 'message' => 'Chưa đăng nhập.'], 401);
        }

        $actor = $group->members()->where('user_id', $actorUser->id)->first();
        if (!$actor || $actor->role !== 'owner') {
            return response()->json([
                'code'    => 'not_owner',
                'message' => 'Chỉ chủ phòng mới có quyền kick thành viên.',
                'debug'   => ['actor_user_id' => $actorUser->id, 'actor_member' => optional($actor)->only(['id','role'])],
            ], 403);
        }

        if ((string)$userId === (string)$actorUser->id) {
            return response()->json([
                'code'    => 'self_kick_forbidden',
                'message' => 'Không thể kick chính mình. Dùng API leave để tự rời phòng.',
            ], 422);
        }

        $target = $group->members()
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhere('id', (int)$userId);
            })
            ->first();

        if (!$target) {
            return response()->json([
                'code'    => 'target_not_in_group',
                'message' => 'Người dùng này không thuộc phòng.',
                'input'   => (string)$userId,
            ], 404);
        }

        DB::transaction(function () use ($group, $target) {
            GroupOrderItem::where('group_order_id', $group->id)
                ->where('member_id', $target->id)
                ->delete();

            GroupOrderSettlement::where('group_order_id', $group->id)
                ->where('member_id', $target->id)
                ->delete();

            $target->delete();
        });

        $this->updateUserGroupCartStatus((int) $target->user_id);

        return response()->json([
            'success'        => true,
            'message'        => 'Đã kick thành viên khỏi phòng.',
            'kicked_user_id' => (int) $target->user_id,
            'members_count'  => $group->members()->count(),
            'group_status'   => $group->fresh()->status,
        ]);
    }

    /**
     * Tự rời phòng (BẮT BUỘC JWT)
     */
    public function leave(Request $req, string $token)
    {
        $group = GroupOrder::where('join_token', $token)->firstOrFail();
        if ($group->status !== 'open') {
            return response()->json([
                'message' => "Phòng đang ở trạng thái '{$group->status}', không thể rời phòng."
            ], 409);
        }

        $actorUser = $req->user();
        if (!$actorUser) {
            return response()->json(['message' => 'Chưa đăng nhập.'], 401);
        }

        $actor = $group->members()->where('user_id', $actorUser->id)->first();
        if (!$actor) {
            return response()->json(['message' => 'Bạn chưa tham gia phòng này.'], 403);
        }

        if ($actor->role === 'owner') {
            $hasOthers = $group->members()->where('user_id', '<>', $actorUser->id)->exists();
            if ($hasOthers) {
                return response()->json([
                    'message' => 'Chủ phòng không thể rời khi vẫn còn thành viên khác. Hãy chuyển quyền chủ hoặc giải tán phòng.'
                ], 422);
            }
        }

        DB::transaction(function () use ($group, $actor) {
            GroupOrderItem::where('group_order_id', $group->id)
                ->where('member_id', $actor->id)
                ->delete();

            GroupOrderSettlement::where('group_order_id', $group->id)
                ->where('member_id', $actor->id)
                ->delete();

            $actor->delete();
        });

        $this->updateUserGroupCartStatus($actorUser->id);

        $remainingCount = $group->members()->count();
        if ($remainingCount === 0) {
            $group->update(['status' => 'closed']);
            return response()->json([
                'success' => true,
                'message' => 'Bạn đã rời phòng. Phòng không còn thành viên nên đã được đóng.',
                'group_status' => 'closed',
                'members_count' => 0,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bạn đã rời phòng.',
            'members_count' => $remainingCount,
            'group_status' => $group->fresh()->status,
        ]);
    }

    /**
     * Xoá nhiều items cùng lúc (owner hoặc chính chủ)
     */
    public function removeItems(Request $req, string $token)
{
    $data = $req->validate([
        'ids'   => 'required|array|min:1',
        'ids.*' => 'integer|exists:group_order_items,id',
    ]);

    $group = GroupOrder::where('join_token', $token)->with('members:id,user_id')->firstOrFail();
    if ($group->status !== 'open' || ($group->expires_at && now()->greaterThan($group->expires_at))) {
        return response()->json(['success'=>false,'message'=>'Group không còn mở'], 409);
    }

    $userId = $req->user()->id;
    $isMember = $group->members->contains(fn($m) => (string)$m->user_id === (string)$userId);
    if (!$isMember) return response()->json(['success'=>false,'message'=>'Bạn không thuộc group này'], 403);

    // (tuỳ chọn) lọc khỏi danh sách những item không phải pending
    $items = $group->items()->whereIn('id', $data['ids'])->get(['id','status']);
    $block = $items->first(fn($i) => !empty($i->status) && $i->status !== 'pending'); // <-- fixed

    if ($block) return response()->json(['success'=>false,'message'=>'Có item không ở trạng thái pending'], 409);

    GroupOrderItem::whereIn('id', $data['ids'])->delete();

    return response()->json(['success' => true, 'deleted' => $data['ids']]);
}


    /**
     * Update số lượng item (tăng/giảm)
     */
    public function updateItemQuantity(Request $req, string $token, int $id)
    {
        $data = $req->validate([
            'quantity' => 'required|integer',
        ]);

        $group = GroupOrder::open()->where('join_token', $token)->firstOrFail();
        $item = $group->items()->with('member', 'book')->findOrFail($id);

        $userId = $req->user()->id;
        $isOwner = $group->members()->where('user_id', $userId)->where('role', 'owner')->exists();
        $isSelf = $item->member && $item->member->user_id === $userId;

        if (!$isOwner && !$isSelf) {
            return response()->json(['message' => 'Không có quyền chỉnh số lượng item này'], 403);
        }

        $newQty = $item->quantity + $data['quantity'];
        if ($newQty < 1) {
            return response()->json(['message' => 'Số lượng phải >= 1'], 400);
        }

        if ($item->book->is_physical && $item->book->stock < $newQty) {
            return response()->json(['message' => 'Không đủ tồn kho'], 400);
        }

        $item->update(['quantity' => $newQty]);

        return response()->json([
            'success' => true,
            'item' => $item->fresh(['book:id,title,price'])
        ]);
    }

    /* ================== Helpers ================== */

    private function genOrderCode(): string
    {
        $today = now();
        $datePrefix = $today->format('dmY');
        $count = Order::whereDate('created_at', $today->toDateString())->count();
        return $datePrefix . str_pad($count + 1, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Cập nhật trạng thái is_group_cart cho user
     */
    private function updateUserGroupCartStatus(int $userId): void
    {
        $stillInAnyOpen = GroupOrder::where('status', 'open')
            ->whereHas('members', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->exists();

        if (!$stillInAnyOpen) {
            User::where('id', $userId)->update(['is_group_cart' => false]);
        }
    }

    public function recalc(Request $req, string $token)
    {
        $group = GroupOrder::where('join_token', $token)
            ->where('status', 'open')->with(['items', 'members'])->firstOrFail();

        $byMember = $group->items->groupBy('member_id');
        $subtotal = $group->items->sum(fn($i) => $i->quantity * $i->price_snapshot);

        $shipping = (int) round((float) $req->input('shipping_fee', 0));
        $count = max(1, $group->members->count());

        $base = intdiv($shipping, $count);
        $rem  = $shipping % $count;

        foreach ($group->members as $idx => $m) {
            $mSubtotal = ($byMember[$m->id] ?? collect())
                ->sum(fn($i) => $i->quantity * $i->price_snapshot);
            $share = $base + ($idx < $rem ? 1 : 0);
            $amount = (int) ($mSubtotal + $share);

            GroupOrderSettlement::updateOrCreate(
                ['group_order_id' => $group->id, 'member_id' => $m->id],
                ['amount_due' => $amount]
            );
        }

        return response()->json([
            'subtotal'    => $subtotal,
            'shipping'    => $shipping,
            'total'       => $subtotal + $shipping,
            'settlements' => $group->settlements()->with('member:id,display_name,role,user_id')->get(),
        ]);
    }

    public function createPayLinks(Request $req, string $token)
    {
        $req->validate([
            'gateway' => 'required|in:momo,vnpay',
            'subject' => 'nullable|string|max:120',
            'message' => 'nullable|string|max:1000',
        ]);

        $group = GroupOrder::where('join_token', $token)
            ->where('status', 'open')
            ->with(['members.user', 'settlements'])
            ->firstOrFail();

        $gateway  = $req->input('gateway');
        $subject  = $req->input('subject', 'Thanh toán nhóm');
        $extraMsg = $req->input('message');

        $links = [];

        DB::transaction(function () use ($group, $gateway, $subject, $extraMsg, &$links) {
            foreach ($group->members as $m) {
                $settle = $group->settlements->firstWhere('member_id', $m->id);
                $amount = (int) ($settle->amount_due ?? 0);
                if ($amount <= 0) continue;

                $payment = GroupOrderPayment::updateOrCreate(
                    ['group_order_id' => $group->id, 'member_id' => $m->id],
                    ['gateway' => $gateway, 'amount' => $amount, 'status' => 'pending']
                );

                if ($gateway === 'momo') {
                    $payload = $this->momoCreatePayment(
                        orderId: 'GO-'.$group->id.'-M'.$m->id.'-'.time(),
                        amount: $amount,
                        orderInfo: "Thanh toán nhóm #{$group->id} - {$m->display_name}"
                    );
                    $payment->update([
                        'provider_txn_id' => $payload['orderId'] ?? null,
                        'pay_url'         => $payload['payUrl'] ?? null,
                        'meta'            => $payload,
                    ]);
                } else {
                    $payload = $this->vnpayCreatePayment(
                        txnRef: 'GO'.$group->id.'M'.$m->id.time(),
                        amount: $amount,
                        orderInfo: "Thanh toán nhóm #{$group->id} - {$m->display_name}"
                    );
                    $payment->update([
                        'provider_txn_id' => $payload['vnp_TxnRef'] ?? null,
                        'pay_url'         => $payload['payUrl'] ?? null,
                        'meta'            => $payload,
                    ]);
                }

                $links[] = [
                    'member_id'   => $m->id,
                    'member_name' => $m->display_name,
                    'email'       => optional($m->user)->email,
                    'amount'      => $amount,
                    'gateway'     => $gateway,
                    'pay_url'     => $payment->pay_url,
                ];

                if ($m->user && $m->user->email && $payment->pay_url) {
                    try {
                        Mail::to($m->user->email)->send(new GroupPaymentLinkMail(
                            subject: $subject,
                            memberName: $m->display_name,
                            amount: $amount,
                            payUrl: $payment->pay_url,
                            extraMsg: $extraMsg
                        ));
                        $payment->update(['email_sent_at' => now()]);
                    } catch (\Throwable $e) {
                        \Log::warning('Send mail failed', ['member_id' => $m->id, 'err' => $e->getMessage()]);
                    }
                }
            }
        });

        return response()->json(['success' => true, 'gateway' => $gateway, 'links' => $links]);
    }

    private function momoCreatePayment(string $orderId, int $amount, string $orderInfo): array
    {
        $hostname     = 'test-payment.momo.vn';
        $endpointPath = '/v2/gateway/api/create';
        $partnerCode  = 'MOMO';
        $accessKey    = 'F8BBA842ECF85';
        $secretKey    = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
        $redirectUrl  = 'http://localhost:8000/api/group-orders/payments/momo/return';
        $ipnUrl       = 'http://localhost:8000/api/group-orders/payments/momo/ipn';
        $requestType  = 'payWithMethod';

        $endpoint = 'https://' . $hostname . $endpointPath;

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => 'SmartBook',
            'storeId'     => 'SmartBookStore',
            'requestId'   => $orderId,
            'amount'      => (string) $amount,
            'orderId'     => $orderId,
            'orderInfo'   => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl'      => $ipnUrl,
            'lang'        => 'vi',
            'requestType' => $requestType,
            'extraData'   => base64_encode(json_encode(['type' => 'group'])),
        ];

        $raw = "accessKey={$accessKey}&amount={$data['amount']}&extraData={$data['extraData']}&ipnUrl={$data['ipnUrl']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&partnerCode={$partnerCode}&redirectUrl={$data['redirectUrl']}&requestId={$data['requestId']}&requestType={$data['requestType']}";
        $data['signature'] = hash_hmac('sha256', $raw, $secretKey);

        try {
            $res = Http::acceptJson()->post($endpoint, $data);
            $json = $res->json() ?? [];
            $payUrl = $json['payUrl'] ?? $json['deeplink'] ?? null;

            if (!$payUrl) {
                \Log::warning('MoMo no payUrl', ['status' => $res->status(), 'body' => $json]);
            }

            return [
                'orderId'     => $orderId,
                'payUrl'      => $payUrl,
                'raw'         => $json,
                'http_status' => $res->status(),
            ];
        } catch (\Throwable $e) {
            \Log::error('MoMo request failed', ['err' => $e->getMessage()]);
            return [
                'orderId'     => $orderId,
                'payUrl'      => null,
                'raw'         => ['error' => $e->getMessage()],
                'http_status' => 0,
            ];
        }
    }

    private function vnpayCreatePayment(string $txnRef, int $amount, string $orderInfo): array
    {
        $tmnCode    = '9AZ5L4B0';
        $hashSecret = 'ENX7GP7VG112B51LB9V3BD00BOJNID93';
        $vnpUrl     = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $returnUrl  = 'http://localhost:8000/api/group-orders/payments/vnpay/return';

        foreach (['tmnCode' => $tmnCode, 'hashSecret' => $hashSecret, 'vnpUrl' => $vnpUrl, 'returnUrl' => $returnUrl] as $k => $v) {
            if (empty($v)) throw new \RuntimeException("VNPay config missing: {$k}");
        }

        $input = [
            'vnp_Version'    => '2.1.0',
            'vnp_TmnCode'    => $tmnCode,
            'vnp_Amount'     => $amount * 100,
            'vnp_Command'    => 'pay',
            'vnp_CreateDate' => now()->format('YmdHis'),
            'vnp_CurrCode'   => 'VND',
            'vnp_IpAddr'     => request()->ip(),
            'vnp_Locale'     => 'vn',
            'vnp_OrderInfo'  => $orderInfo,
            'vnp_OrderType'  => 'other',
            'vnp_ReturnUrl'  => $returnUrl,
            'vnp_TxnRef'     => $txnRef,
        ];

        ksort($input);
        $hashdataParts = [];
        $queryParts    = [];
        foreach ($input as $k => $v) {
            $hashdataParts[] = urlencode($k) . '=' . urlencode($v);
            $queryParts[]    = urlencode($k) . '=' . urlencode($v);
        }
        $hashdata   = implode('&', $hashdataParts);
        $secureHash = hash_hmac('sha512', $hashdata, $hashSecret);
        $payUrl     = $vnpUrl . '?' . implode('&', $queryParts) . '&vnp_SecureHash=' . $secureHash;

        return ['vnp_TxnRef' => $txnRef, 'payUrl' => $payUrl];
    }

    // --- MoMo Return (local) ---
    public function momoReturn(Request $req)
    {
        $orderId    = $req->input('orderId');
        $resultCode = (int) $req->input('resultCode', -1);

        $pay = GroupOrderPayment::where('provider_txn_id', $orderId)->first();
        if (!$pay) return response()->json(['message' => 'not found'], 404);

        if ($resultCode === 0) {
            $pay->update(['status' => 'paid', 'paid_at' => now()]);
        } else {
            $pay->update(['status' => 'failed']);
        }

        // ❌ KHÔNG auto finalize ở đây nữa
        return response()->json(['success' => $resultCode === 0]);
    }

    // --- VNPay Return (verify hash đơn giản) ---
    public function vnpayReturn(Request $req)
    {
        $params = $req->all();
        $txnRef = $params['vnp_TxnRef'] ?? null;
        $code   = $params['vnp_ResponseCode'] ?? null;
        $hash   = $params['vnp_SecureHash'] ?? null;

        $hashSecret = 'ENX7GP7VG112B51LB9V3BD00BOJNID93';

        $paramsForHash = $params;
        unset($paramsForHash['vnp_SecureHash'], $paramsForHash['vnp_SecureHashType']);
        ksort($paramsForHash);
        $hashdataParts = [];
        foreach ($paramsForHash as $k => $v) $hashdataParts[] = urlencode($k).'='.urlencode($v);
        $calc = hash_hmac('sha512', implode('&', $hashdataParts), $hashSecret);

        if (!$txnRef) return response()->json(['message' => 'invalid return'], 400);

        $pay = GroupOrderPayment::where('provider_txn_id', $txnRef)->first();
        if (!$pay) return response()->json(['message' => 'not found'], 404);

        if (hash_equals($calc, (string)$hash) && $code === '00') {
            $pay->update(['status' => 'paid', 'paid_at' => now()]);
        } else {
            $pay->update(['status' => 'failed']);
        }

        // ❌ KHÔNG auto finalize ở đây nữa
        return response()->json(['success' => ($code === '00')]);
    }

    // --- đồng bộ local khi IPN không về (query MoMo) ---
    public function syncPendingPayments(Request $req, string $token)
    {
        $group = GroupOrder::where('join_token',$token)->with('payments')->firstOrFail();

        foreach ($group->payments()->where('gateway','momo')->where('status','pending')->get() as $p) {
            $j = $this->momoQuery($p->provider_txn_id);
            $code = (int)($j['resultCode'] ?? -1);
            if ($code === 0)        $p->update(['status'=>'paid','paid_at'=>now()]);
            elseif ($code > 0)      $p->update(['status'=>'failed']);
        }

        // ❌ KHÔNG auto finalize ở đây nữa
        return response()->json(['success'=>true]);
    }

    private function momoQuery(string $orderId): array
    {
        $endpoint   = 'https://test-payment.momo.vn/v2/gateway/api/query';
        $partnerCode= 'MOMO';
        $accessKey  = 'F8BBA842ECF85';
        $secretKey  = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
        $requestId  = $orderId;

        $raw = "accessKey={$accessKey}&orderId={$orderId}&partnerCode={$partnerCode}&requestId={$requestId}";
        $signature = hash_hmac('sha256', $raw, $secretKey);

        $res = Http::post($endpoint, [
            'partnerCode' => $partnerCode,
            'requestId'   => $requestId,
            'orderId'     => $orderId,
            'signature'   => $signature,
            'lang'        => 'vi',
        ]);

        return $res->json() ?? [];
    }

    public function momoIpn(Request $req)
    {
        $orderId    = $req->input('orderId');
        $resultCode = (int) $req->input('resultCode', -1);

        $pay = GroupOrderPayment::where('provider_txn_id', $orderId)->first();
        if (!$pay) return response('not found', 404);

        if ($resultCode === 0) {
            $pay->update(['status' => 'paid', 'paid_at' => now()]);
        } else {
            $pay->update(['status' => 'failed']);
        }

        // ❌ KHÔNG auto finalize ở đây nữa
        return response('ok');
    }

    /**
     * No-op: không còn tự finalize ở bất kỳ đâu ngoài checkout()
     */
    private function tryFinalizeGroupOrder(int $groupId): void
    {
        // intentionally empty
    }

    public function status(Request $req, string $token)
    {
        $group = GroupOrder::with(['members','settlements','payments'])->where('join_token',$token)->firstOrFail();
        [$allPaid, $unpaid] = $this->checkAllMembersPaid($group->id);

        return response()->json([
            'group_status' => $group->status,
            'all_paid'     => $allPaid,
            'unpaid'       => $unpaid,
            'order_id'     => $group->order_id,
        ]);
    }
}
