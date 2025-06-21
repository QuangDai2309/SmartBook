@extends('layouts.admin.admin')
@section('title', 'Quản lý Nhà Xuất Bản')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Quản lý Nhà Xuất Bản</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="row g-3 mb-3" method="GET">
        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm tên NXB..." value="{{ $keyword }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Tìm kiếm</button>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.publishers.create') }}" class="btn btn-success">+ Thêm NXB</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($publishers as $publisher)
                    <tr>
                        <td>{{ ($publishers->currentPage() - 1) * $publishers->perPage() + $loop->iteration }}</td>
                        <td>{{ $publisher->name }}</td>
                        <td>{{ $publisher->is_hidden ? 'Ẩn' : 'Hiện' }}</td>
                        <td>{{ $publisher->created_at->format('d/m/Y') }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.publishers.edit', $publisher) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="{{ route('admin.publishers.destroy', $publisher) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xóa?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Không có dữ liệu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $publishers->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
