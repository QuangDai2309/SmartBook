@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">📚 Danh sách sách</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-3">➕ Thêm sách</a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tên sách</th>
                <th>Tác giả</th>
                <th>NXB</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Tồn kho</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $index => $book)
            <tr>
                <td>{{ $index + 1 }}</td>

                {{-- Ảnh chính --}}
                <td>
                    @if ($book->mainImage)
                        <img src="{{ $book->mainImage->image_url }}" width="60" style="object-fit: cover;">
                    @else
                        <span class="text-muted fst-italic">Chưa có</span>
                    @endif
                </td>

                {{-- Tên sách --}}
                <td>{{ $book->title }}</td>

                {{-- Tác giả, NXB, Danh mục --}}
                <td>{{ optional($book->author)->name ?? 'Chưa có' }}</td>
                <td>{{ optional($book->publisher)->name ?? 'Chưa có' }}</td>
                <td>{{ optional($book->category)->name ?? 'Chưa có' }}</td>

                {{-- Giá, tồn kho --}}
                <td>{{ number_format($book->price, 0, ',', '.') }}đ</td>
                <td>{{ $book->stock }}</td>

                {{-- Hành động --}}
                <td>
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning btn-sm">✏️</a>
                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa sách này?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div class="mt-4 text-center">
        {{ $books->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
