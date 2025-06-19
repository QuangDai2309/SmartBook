@extends('layouts.admin.admin')
@section('title', 'Thêm Tác giả')
@section('content')
<div class="container mt-4">
    <h2>Thêm tác giả mới</h2>
    <form action="{{ route('admin.authors.store') }}" method="POST">
        @include('admin.authors._form', ['author' => new \App\Models\Author()])
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
