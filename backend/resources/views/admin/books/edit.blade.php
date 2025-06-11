@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Edit Book</h1>
    <form action="{{ route('books.update', $book) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.books.form', ['book' => $book])
    </form>
@endsection
