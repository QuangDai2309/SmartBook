@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Book Management</h1>
        <a href="{{ route('books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Book</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Author</th>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Publisher</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Stock</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $book->title }}</td>
                    <td class="px-4 py-2">{{ $book->author->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $book->category->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $book->publisher->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ number_format($book->price, 0, ',', '.') }}đ</td>
                    <td class="px-4 py-2">{{ $book->stock }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('books.edit', $book) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection
