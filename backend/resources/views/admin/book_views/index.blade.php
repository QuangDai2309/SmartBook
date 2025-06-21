@extends('layouts.admin.admin')

@section('title', 'Thống kê Lượt xem Sách')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Lượt xem Sách</h1>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Sách</th>
                    <th>Người dùng</th>
                    <th>Lượt xem</th>
                    <th>Xem lần cuối</th>
                </tr>
            </thead>
            <tbody>
                @forelse($views as $index => $view)
                    <tr>
                        <td>{{ $views->firstItem() + $index }}</td>
                        <td>{{ $view->book->title ?? '[Đã xóa]' }}</td>
                        <td>{{ $view->user->name ?? 'Khách' }}</td>
                        <td>{{ $view->view_count }}</td>
                        <td>
                            {{ $view->last_viewed_at
                                ? \Carbon\Carbon::parse($view->last_viewed_at)->format('H:i d/m/Y')
                                : '-'
                            }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Không có dữ liệu lượt xem.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $views->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
