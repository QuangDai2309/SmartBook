@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Books</h1>
        <a href="{{ route('books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Add New</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full table-auto bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Stock</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $book->title }}</td>
                <td class="px-4 py-2">${{ $book->price }}</td>
                <td class="px-4 py-2">{{ $book->stock }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('books.edit', $book) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
@endsection
