@extends('layouts.admin.admin')
@section('title', 'Sửa Tag')

@section('content')
<div class="container mt-4">
    <h2>Sửa Tag</h2>
    @include('admin.tags._form', [
        'formAction' => route('admin.tags.update', $tag->id),
        'isEdit' => true,
        'tag' => $tag
    ])
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Hủy</a>
</form>
</div>
@endsection
