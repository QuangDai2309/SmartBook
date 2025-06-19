@extends('layouts.admin.admin')

@section('title', 'Quản lý Người dùng')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Quản lý Người dùng</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form tìm kiếm --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên hoặc email..."
                    value="{{ request('keyword') }}">
            </div>
        </form>

        {{-- Bảng danh sách --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Vai trò</th> {{-- THÊM --}}
                        <th>Trạng thái</th>
                        <th class="text-nowrap">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                    <span class="badge bg-warning text-dark">Admin</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->is_hidden)
                                    <span class="badge bg-secondary">Ẩn</span>
                                @else
                                    <span class="badge bg-success">Hiện</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Xác nhận xóa người dùng này?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Không có người dùng nào.</td>
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
