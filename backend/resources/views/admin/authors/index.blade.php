@extends('layouts.app') {{-- Giả sử bạn đang dùng layout Bootstrap --}}

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">📚 Danh sách Tác giả</h1>

    <a href="{{ route('admin.authors.create') }}" class="btn btn-primary mb-3">➕ Thêm mới</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên tác giả</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                    <td>
                        <a href="{{ route('admin.authors.edit', $author) }}" class="btn btn-sm btn-warning">Sửa</a>

                        <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
