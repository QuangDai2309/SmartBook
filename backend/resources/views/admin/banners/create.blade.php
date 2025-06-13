@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>🎨 Thêm Banner</h1>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Hình ảnh</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Liên kết (nếu có)</label>
            <input type="url" name="link" class="form-control">
        </div>

        <button class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
