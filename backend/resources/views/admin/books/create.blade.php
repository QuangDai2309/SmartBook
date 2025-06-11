@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">{{ isset($book) ? 'Edit' : 'Add' }} Book</h1>
    <form method="POST" action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}">
        @csrf
        @if(isset($book)) @method('PUT') @endif

        <div class="mb-4">
            <label class="block">Title</label>
            <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $book->price ?? '') }}" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $book->stock ?? '') }}" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
    <label class="block font-semibold">Author</label>
    <select name="author_id" class="w-full border px-3 py-2 rounded" required>
        @foreach($authors as $author)
            <option value="{{ $author->id }}" {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                {{ $author->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block font-semibold">Category</label>
    <select name="category_id" class="w-full border px-3 py-2 rounded" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block font-semibold">Publisher</label>
    <select name="publisher_id" class="w-full border px-3 py-2 rounded" required>
        @foreach($publishers as $publisher)
            <option value="{{ $publisher->id }}" {{ old('publisher_id', $book->publisher_id ?? '') == $publisher->id ? 'selected' : '' }}>
                {{ $publisher->name }}
            </option>
        @endforeach
    </select>
</div>


        <button class="bg-green-600 text-white px-4 py-2 rounded">
            {{ isset($book) ? 'Update' : 'Create' }}
        </button>
    </form>
</div>
@endsection
