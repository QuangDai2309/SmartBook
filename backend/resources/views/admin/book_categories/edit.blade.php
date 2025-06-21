@extends('layouts.admin.admin')
@section('title', 'Chỉnh sửa Danh mục Sách')

@section('content')
<div class="container mt-4">
    <h2>Chỉnh sửa: {{ $category->name }}</h2>

    <form action="{{ route('admin.book_categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.book_categories._form', ['category' => $category])
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.book_categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
