@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">✍️ Thêm Tác giả mới</h1>

    {{-- Hiển thị lỗi nếu có --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.authors.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên tác giả</label>
            <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <button type="submit" class="btn btn-success">💾 Lưu</button>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary ms-2">↩️ Quay lại</a>
    </form>
</div>
@endsection
