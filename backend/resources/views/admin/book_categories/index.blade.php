@extends('layouts.admin.admin')
@section('title', 'Quản lý Danh mục Sách')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Quản lý Danh mục Sách</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form tìm kiếm & lọc --}}
    <form method="GET" action="{{ route('admin.book_categories.index') }}" class="row g-3 mb-3 align-items-end">
        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên danh mục..." value="{{ request('keyword') }}">
        </div>
        <div class="col-md-3">
            <select name="parent_id" class="form-select">
                <option value="">-- Tất cả danh mục cha --</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Lọc</button>
        </div>
        <div class="col-md-3 text-end">
            <a href="{{ route('admin.book_categories.create') }}" class="btn btn-success">+ Thêm danh mục</a>
        </div>
    </form>

    {{-- Bảng danh sách --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>Danh mục cha</th>
                    <th>Thứ tự</th>
                    <th>Hiển thị</th>
                    <th class="text-nowrap">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $cate)
                    <tr>
                        <td>{{ $categories->firstItem() + $index }}</td>
                        <td>{{ $cate->name }}</td>
                        <td>{{ $cate->slug }}</td>
                        <td>{{ $cate->parent?->name ?? '-' }}</td>
                        <td>{{ $cate->order_index }}</td>
                        <td>{{ $cate->is_hidden ? 'Ẩn' : 'Hiện' }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.book_categories.edit', $cate->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="{{ route('admin.book_categories.destroy', $cate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xóa?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có danh mục nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
