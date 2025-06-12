@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">📚 Danh sách sách</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-3">➕ Thêm sách</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th><th>Tên sách</th><th>Tác giả</th><th>NXB</th><th>Danh mục</th>
                <th>Giá</th><th>Tồn kho</th><th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
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
</div>
@endsection
