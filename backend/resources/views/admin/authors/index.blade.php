@extends('layouts.admin.admin')
@section('title', 'Quản lý Tác giả')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Quản lý Tác giả</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form tìm kiếm & nút thêm --}}
    <form method="GET" action="{{ route('admin.authors.index') }}" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên tác giả..." value="{{ request('keyword') }}">
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.authors.create') }}" class="btn btn-success">+ Thêm tác giả</a>
        </div>
    </form>

    {{-- Bảng danh sách --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th class="text-nowrap">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $author)
                    <tr>
                        <td>{{ $authors->firstItem() + $loop->index }}</td>
                        <td>{{ $author->name }}</td>
                        <td>{{ $author->is_hidden ? 'Ẩn' : 'Hiện' }}</td>
                        <td>{{ $author->created_at->format('d/m/Y') }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.authors.edit', $author) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xóa?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Không có tác giả nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $authors->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
