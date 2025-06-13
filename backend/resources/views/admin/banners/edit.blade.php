@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>✏️ Chỉnh sửa Banner</h1>

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Hình ảnh hiện tại:</label><br>
            <img src="{{ asset('storage/' . $banner->image) }}" width="150">
        </div>

        <div class="mb-3">
            <label>Chọn hình ảnh mới (nếu muốn thay)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Liên kết</label>
            <input type="url" name="link" value="{{ old('link', $banner->link) }}" class="form-control">
        </div>

        <button class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
