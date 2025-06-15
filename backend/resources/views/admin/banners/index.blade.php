@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">📢 Danh sách Banner</h1>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-success mb-3">+ Thêm mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Hình ảnh</th>
                <th>Liên kết</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $banner)
                <tr>
                    <td>{{ $banner->id }}</td>
                    <td><img src="{{ asset('storage/' . $banner->image) }}" width="120"></td>
                    <td>{{ $banner->link }}</td>
                    <td>
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-primary">Sửa</a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa banner này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
