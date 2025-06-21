@extends('layouts.admin.admin')

@section('title', 'Thêm Sách')

@section('content')
<div class="container mt-4">
    <h2>Thêm Sách Mới</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.books.store') }}" method="POST">
        @csrf
        @include('admin.books._form', ['book' => null])
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection


