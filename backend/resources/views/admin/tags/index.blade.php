@extends('layouts.admin.admin')
@section('title', 'Quản lý Tag')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Quản lý Tag</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tìm kiếm --}}
    <form method="GET" action="{{ route('admin.tags.index') }}" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên tag..." value="{{ request('keyword') }}">
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.tags.create') }}" class="btn btn-success">+ Thêm Tag</a>
        </div>
    </form>

    {{-- Danh sách --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>Hiển thị</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tags as $index => $tag)
                <tr>
                    <td>{{ $tags->firstItem() + $index }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td>{{ $tag->is_hidden ? 'Ẩn' : 'Hiện' }}</td>
                    <td class="text-nowrap text-center">
                        <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                        <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa tag này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Không có tag nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $tags->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
