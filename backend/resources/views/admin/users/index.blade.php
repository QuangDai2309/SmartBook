@extends('layouts.admin.admin')
@section('title', 'Quản lý Người dùng')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Quản lý Người dùng</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tìm kiếm --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên hoặc email..."
                value="{{ request('keyword') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    {{-- Bảng --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th class="text-nowrap">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span></td>
                        <td>
                            @if ($user->is_hidden)
                                <span class="badge bg-secondary">Ẩn</span>
                            @else
                                <span class="badge bg-success">Hiện</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Sửa</a>

                            {{-- Toggle Ẩn/Hiện --}}
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm {{ $user->is_hidden ? 'btn-success' : 'btn-warning' }}">
                                    {{ $user->is_hidden ? 'Hiện lại' : 'Ẩn' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có người dùng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
