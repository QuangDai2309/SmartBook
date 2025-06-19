<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'user')
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->keyword}%")
                      ->orWhere('email', 'like', "%{$request->keyword}%");
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'is_hidden' => 'required|boolean',
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'Xóa người dùng thành công!');
    }
}
