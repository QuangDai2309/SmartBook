@extends('layouts.admin.admin')
@section('title', 'Thêm Tag')

@section('content')
<div class="container mt-4">
    <h2>Thêm Tag</h2>
    @include('admin.tags._form', ['formAction' => route('admin.tags.store'), 'isEdit' => false, 'tag' => null])
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Hủy</a>
</form>
</div>
@endsection
