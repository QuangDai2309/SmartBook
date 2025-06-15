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
                <td>{{ $book->title }}</td>
                <td>{{ $book->author->name }}</td>
                <td>{{ $book->publisher->name }}</td>
                <td>{{ $book->category->name }}</td>
                <td>{{ number_format($book->price, 0, ',', '.') }}đ</td>
                <td>{{ $book->stock }}</td>
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
    <div class="mt-4 text-center">
            {{ $books->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
</div>
@endsection
