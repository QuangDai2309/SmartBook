@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">📚 Danh sách Nhà xuất bản</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.publishers.create') }}" class="btn btn-primary mb-3">➕ Thêm mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên NXB</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($publishers as $publisher)
            <tr>
                <td>{{ $publisher->id }}</td>
                <td>{{ $publisher->name }}</td>
                <td>
                    <a href="{{ route('admin.publishers.edit', $publisher) }}" class="btn btn-sm btn-warning">✏️ Sửa</a>
                    <form action="{{ route('admin.publishers.destroy', $publisher) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa nhà xuất bản này?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑️ Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
