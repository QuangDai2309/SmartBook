@extends('layouts.admin.admin')
@section('title', 'Thêm NXB')

@section('content')
<div class="container mt-4">
    <h2>Thêm NXB mới</h2>
    <form action="{{ route('admin.publishers.store') }}" method="POST">
        @include('admin.publishers._form', ['publisher' => new \App\Models\Publisher()])
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.publishers.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
