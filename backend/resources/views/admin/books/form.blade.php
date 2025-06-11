@csrf

<div class="mb-4">
    <label class="block font-semibold">Title</label>
    <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" class="w-full border px-3 py-2 rounded" required>
</div>

<div class="mb-4">
    <label class="block font-semibold">Price</label>
    <input type="number" step="0.01" name="price" value="{{ old('price', $book->price ?? '') }}" class="w-full border px-3 py-2 rounded" required>
</div>

<div class="mb-4">
    <label class="block font-semibold">Stock</label>
    <input type="number" name="stock" value="{{ old('stock', $book->stock ?? '') }}" class="w-full border px-3 py-2 rounded" required>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    {{ isset($book) ? 'Update' : 'Create' }}
</button>
