@csrf
<div class="mb-3">
    <label for="name" class="form-label">Tên NXB</label>
    <input type="text" class="form-control" name="name" value="{{ old('name', $publisher->name ?? '') }}" required>
</div>
<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_hidden" value="1" {{ old('is_hidden', $publisher->is_hidden ?? false) ? 'checked' : '' }}>
    <label class="form-check-label">Ẩn NXB</label>
</div>
