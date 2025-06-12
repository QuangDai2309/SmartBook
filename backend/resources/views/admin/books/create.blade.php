@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">➕ Thêm sách mới</h1>

    <form action="{{ route('admin.books.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tiêu đề sách</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tác giả</label>
            <select name="author_id" class="form-control" required>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nhà xuất bản</label>
            <select name="publisher_id" class="form-control" required>
                @foreach ($publishers as $publisher)
                    <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Danh mục</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" step="1000" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Số lượng tồn kho</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
