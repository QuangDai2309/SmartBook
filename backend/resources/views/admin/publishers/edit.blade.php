@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">✏️ Chỉnh sửa Nhà xuất bản</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.publishers.update', $publisher) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên nhà xuất bản</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $publisher->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.publishers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
a
