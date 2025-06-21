@extends('layouts.admin.admin')

@section('title', 'Quản lý Mã Giảm Giá')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Quản lý Mã Giảm Giá</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form tìm kiếm và nút thêm --}}
    <form method="GET" action="{{ route('admin.vouchers.index') }}" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm mã giảm giá..."
                value="{{ request('keyword') }}">
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success">+ Thêm mã giảm giá</a>
        </div>
    </form>

    {{-- Bảng danh sách --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Mã</th>
                    <th>Loại</th>
                    <th>Giá trị</th>
                    <th>Đơn tối thiểu</th>
                    <th>Số lượng</th>
                    <th>Thời gian</th>
                    <th>Ẩn/Hiện</th>
                    <th class="text-nowrap">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $index => $voucher)
                    <tr>
                        <td>{{ $vouchers->firstItem() + $index }}</td>
                        <td>{{ $voucher->code }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $voucher->discount_type === 'percentage' ? 'Phần trăm' : 'Cố định' }}
                            </span>
                        </td>
                        <td>
                            @if($voucher->discount_type === 'percentage')
                                {{ $voucher->discount_value }}%
                                @if($voucher->max_discount)
                                    <br><small>(Tối đa {{ number_format($voucher->max_discount) }}đ)</small>
                                @endif
                            @else
                                {{ number_format($voucher->discount_value) }}đ
                            @endif
                        </td>
                        <td>{{ number_format($voucher->min_order_value) }}đ</td>
                        <td>{{ $voucher->quantity }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($voucher->start_date)->format('d/m/Y') }} -
                            {{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}
                        </td>
                        <td>
                            @if($voucher->is_hidden)
                                <span class="badge bg-secondary">Ẩn</span>
                            @else
                                <span class="badge bg-success">Hiện</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Xác nhận xóa?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Không có mã giảm giá nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $vouchers->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
