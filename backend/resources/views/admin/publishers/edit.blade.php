@extends('layouts.admin.admin')
@section('title', 'Chỉnh sửa NXB')

@section('content')
<div class="container mt-4">
    <h2>Chỉnh sửa: {{ $publisher->name }}</h2>
    <form action="{{ route('admin.publishers.update', $publisher) }}" method="POST">
        @method('PUT')
        @include('admin.publishers._form', ['publisher' => $publisher])
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.publishers.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
