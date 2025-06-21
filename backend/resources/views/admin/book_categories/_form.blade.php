<div class="mb-3">
    <label for="name" class="form-label">Tên danh mục</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
</div>

<div class="mb-3">
    <label for="slug" class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Mô tả</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
</div>

<div class="mb-3">
    <label for="order_index" class="form-label">Thứ tự hiển thị</label>
    <input type="number" name="order_index" class="form-control" value="{{ old('order_index', $category->order_index ?? 0) }}">
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_hidden" id="is_hidden" {{ old('is_hidden', $category->is_hidden) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_hidden">Ẩn danh mục</label>
</div>
