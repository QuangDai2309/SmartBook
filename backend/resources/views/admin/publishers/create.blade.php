@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">➕ Thêm Nhà xuất bản</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.publishers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên nhà xuất bản</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.publishers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
