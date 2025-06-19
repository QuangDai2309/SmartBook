@extends('layouts.admin.admin')
@section('title', 'Chỉnh sửa Tác giả')
@section('content')
<div class="container mt-4">
    <h2>Chỉnh sửa: {{ $author->name }}</h2>
    <form action="{{ route('admin.authors.update', $author) }}" method="POST">
        @method('PUT')
        @include('admin.authors._form', ['author' => $author])
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
