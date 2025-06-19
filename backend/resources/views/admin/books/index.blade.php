@extends('layouts.admin.admin')

@section('title', 'Quản lý Sách')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Quản lý Sách</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Bộ lọc --}}
        <form method="GET" action="{{ route('admin.books.index') }}" class="row g-3 align-items-end mb-4">
            <div class="col-md-4">
                <label for="keyword" class="form-label">Từ khóa</label>
                <input type="text" name="keyword" id="keyword" class="form-control"
                       placeholder="Tìm theo tên sách..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-4">
                <label for="category_id" class="form-label">Danh mục</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">-- Tất cả danh mục --</option>
                    @foreach ($categories as $cate)
                        <option value="{{ $cate->id }}" {{ request('category_id') == $cate->id ? 'selected' : '' }}>
                            {{ $cate->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Lọc</button>
            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('admin.books.create') }}" class="btn btn-success w-100">+ Thêm sách</a>
            </div>
        </form>

        {{-- Bảng danh sách --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên sách</th>
                        <th>Mã</th>
                        <th>Giá</th>
                        <th>Tác giả</th>
                        <th>NXB</th>
                        <th>Danh mục</th>
                        <th>Loại</th>
                        <th>Trạng thái</th>
                        <th>Hiện</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->book_code }}</td>
                            <td>
                                @if ($book->discount_price)
                                    <span class="text-danger">{{ number_format($book->discount_price) }}đ</span><br>
                                    <small><del>{{ number_format($book->price) }}đ</del></small>
                                @else
                                    {{ number_format($book->price) }}đ
                                @endif
                            </td>
                            <td>{{ $book->author->name ?? 'N/A' }}</td>
                            <td>{{ $book->publisher->name ?? 'N/A' }}</td>
                            <td>{{ $book->category->name ?? 'N/A' }}</td>
                            <td>{{ $book->book_type === 'physical' ? 'Sách in' : 'Ebook' }}</td>
                            <td>
                                @if ($book->status === 'available')
                                    <span class="badge bg-success">Còn hàng</span>
                                @elseif($book->status === 'coming_soon')
                                    <span class="badge bg-warning text-dark">Sắp phát hành</span>
                                @else
                                    <span class="badge bg-secondary">Hết hàng</span>
                                @endif
                            </td>
                            <td>{{ $book->is_hidden ? 'Ẩn' : 'Hiện' }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Xác nhận xóa?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Không có sách nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Phân trang --}}
        <div class="mt-3">
            {{ $books->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
