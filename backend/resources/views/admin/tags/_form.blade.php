<form action="{{ $formAction }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Tên Tag</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $tag->name ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $tag->slug ?? '') }}">
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="is_hidden" class="form-check-input" {{ old('is_hidden', $tag->is_hidden ?? false) ? 'checked' : '' }}>
        <label class="form-check-label">Ẩn Tag</label>
    </div>
