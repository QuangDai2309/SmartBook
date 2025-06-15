@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">🏢 Danh sách Nhà xuất bản</h1>

        <form method="GET" action="{{ route('admin.publishers.index') }}" class="mb-3 d-flex" role="search">
            <input type="text" name="search" class="form-control me-2" placeholder="🔍 Tìm nhà xuất bản..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Tìm</button>
        </form>

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPublisherModal">➕ Thêm mới</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên nhà xuất bản</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($publishers as $index => $publisher)
                    <tr>
                        <td>{{ $publishers->firstItem() + $index }}</td>
                        <td>{{ $publisher->name }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editPublisherModal{{ $publisher->id }}">Sửa</button>
                            <form action="{{ route('admin.publishers.destroy', $publisher) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Không có nhà xuất bản nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4 text-center">
            {{ $publishers->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>

        {{-- Modal chỉnh sửa nhà xuất bản --}}
        @foreach ($publishers as $publisher)
            <div class="modal fade" id="editPublisherModal{{ $publisher->id }}" tabindex="-1"
                 aria-labelledby="editPublisherModalLabel{{ $publisher->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('admin.publishers.update', $publisher->id) }}" method="POST" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPublisherModalLabel{{ $publisher->id }}">✏️ Sửa Nhà xuất bản</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Tên nhà xuất bản</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', e($publisher->name)) }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">✖️ Hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- Modal thêm nhà xuất bản --}}
        <div class="modal fade" id="addPublisherModal" tabindex="-1" aria-labelledby="addPublisherModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.publishers.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPublisherModalLabel">➕ Thêm Nhà xuất bản mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên nhà xuất bản</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">💾 Lưu</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">✖️ Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
