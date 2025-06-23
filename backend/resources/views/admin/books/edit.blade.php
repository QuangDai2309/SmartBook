@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">✏️ Chỉnh sửa sách</h1>

    {{-- Hiển thị thông báo --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Hiển thị lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tiêu đề sách</label>
            <input type="text" name="title" value="{{ old('title', $book->title) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tác giả</label>
            <select name="author_id" class="form-control" required>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nhà xuất bản</label>
            <select name="publisher_id" class="form-control" required>
                @foreach ($publishers as $publisher)
                    <option value="{{ $publisher->id }}" {{ old('publisher_id', $book->publisher_id) == $publisher->id ? 'selected' : '' }}>
                        {{ $publisher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Danh mục</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" step="1000" min="0" value="{{ old('price', $book->price) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Số lượng tồn kho</label>
            <input type="number" name="stock" min="0" value="{{ old('stock', $book->stock) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control my-editor">{{ old('description', $book->description) }}</textarea>
        </div>

        {{-- Ảnh hiện tại --}}
        @if ($book->images->count())
        <div class="mb-3">
            <label>Ảnh hiện tại</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach ($book->images as $image)
                    <div class="border rounded p-2 text-center">
                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}" width="120" class="img-thumbnail mb-1">

                        @if ($image->is_main)
                            <span class="badge bg-primary d-block mb-1">Ảnh chính</span>
                        @else
                            <form action="{{ route('admin.books.set-main-image', $image) }}" method="POST" class="mb-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">Đặt làm chính</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.books.delete-image', $image) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Xoá</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Upload ảnh mới --}}
        <div class="mb-3">
            <label>Thêm ảnh mới (tùy chọn)</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">📏 Cập nhật</button>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('.my-editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush