@php
    $isEdit = isset($book);
@endphp

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Mã sách *</label>
        <input type="text" name="book_code" class="form-control" value="{{ old('book_code', $book->book_code ?? '') }}" required>
    </div>
    <div class="col-md-8">
        <label class="form-label">Tên sách *</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $book->title ?? '') }}" required>
    </div>
    <div class="col-md-12">
        <label class="form-label">Slug URL *</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $book->slug ?? '') }}" required>
    </div>
    <div class="col-md-12">
        <label class="form-label">Mô tả ngắn</label>
        <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $book->description ?? '') }}</textarea>
    </div>

    <div class="col-md-4">
        <label class="form-label">Tác giả *</label>
        <select name="author_id" class="form-select" required>
            <option value="">-- Chọn --</option>
            @foreach($authors as $author)
                <option value="{{ $author->id }}" {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                    {{ $author->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">NXB *</label>
        <select name="publisher_id" class="form-select" required>
            <option value="">-- Chọn --</option>
            @foreach($publishers as $pub)
                <option value="{{ $pub->id }}" {{ old('publisher_id', $book->publisher_id ?? '') == $pub->id ? 'selected' : '' }}>
                    {{ $pub->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Danh mục</label>
        <select name="category_id" class="form-select">
            <option value="">-- Không chọn --</option>
            @foreach($categories as $cate)
                <option value="{{ $cate->id }}" {{ old('category_id', $book->category_id ?? '') == $cate->id ? 'selected' : '' }}>
                    {{ $cate->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Giá *</label>
        <input type="number" name="price" class="form-control" value="{{ old('price', $book->price ?? 0) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Giá khuyến mãi</label>
        <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price', $book->discount_price ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Loại sách *</label>
        <select name="book_type" class="form-select" required>
            <option value="physical" {{ old('book_type', $book->book_type ?? '') == 'physical' ? 'selected' : '' }}>Sách in</option>
            <option value="ebook" {{ old('book_type', $book->book_type ?? '') == 'ebook' ? 'selected' : '' }}>Ebook</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Kho *</label>
        <input type="number" name="stock" class="form-control" value="{{ old('stock', $book->stock ?? 0) }}" required>
    </div>

    <div class="col-md-3">
        <label class="form-label">Năm xuất bản</label>
        <input type="number" name="published_year" class="form-control" value="{{ old('published_year', $book->published_year ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Ngôn ngữ</label>
        <input type="text" name="language" class="form-control" value="{{ old('language', $book->language ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Số trang</label>
        <input type="number" name="page_count" class="form-control" value="{{ old('page_count', $book->page_count ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Trọng lượng (g)</label>
        <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $book->weight ?? '') }}">
    </div>
    <div class="col-md-12">
        <label class="form-label">Kích thước</label>
        <input type="text" name="dimensions" class="form-control" value="{{ old('dimensions', $book->dimensions ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Trạng thái *</label>
        <select name="status" class="form-select" required>
            <option value="available" {{ old('status', $book->status ?? '') == 'available' ? 'selected' : '' }}>Còn hàng</option>
            <option value="coming_soon" {{ old('status', $book->status ?? '') == 'coming_soon' ? 'selected' : '' }}>Sắp phát hành</option>
            <option value="unavailable" {{ old('status', $book->status ?? '') == 'unavailable' ? 'selected' : '' }}>Hết hàng</option>
        </select>
    </div>
    <div class="col-md-4 form-check mt-4">
        <input type="checkbox" class="form-check-input" name="is_featured" {{ old('is_featured', $book->is_featured ?? false) ? 'checked' : '' }}>
        <label class="form-check-label">Sách nổi bật</label>
    </div>
    <div class="col-md-4 form-check mt-4">
        <input type="checkbox" class="form-check-input" name="is_hidden" {{ old('is_hidden', $book->is_hidden ?? true) ? 'checked' : '' }}>
        <label class="form-check-label">Ẩn sách</label>
    </div>
</div>
