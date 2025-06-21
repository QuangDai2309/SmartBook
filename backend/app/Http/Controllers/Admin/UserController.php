<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->keyword, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->only(['name', 'phone', 'address', 'role']));

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công.');
    }


    public function toggle(User $user)
    {
        $user->is_hidden = !$user->is_hidden;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật trạng thái thành công.');
    }
}
