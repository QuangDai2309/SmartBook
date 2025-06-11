@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Add Book</h1>
    <form action="{{ route('books.store') }}" method="POST">
        @include('admin.books.form')
    </form>
@endsection
