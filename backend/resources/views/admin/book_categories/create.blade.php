@extends('layouts.admin.admin')
@section('title', 'Thêm Danh mục Sách')

@section('content')
<div class="container mt-4">
    <h2>Thêm danh mục sách mới</h2>

    <form action="{{ route('admin.book_categories.store') }}" method="POST">
        @csrf
        @include('admin.book_categories._form', ['category' => new \App\Models\BookCategory])
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.book_categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
