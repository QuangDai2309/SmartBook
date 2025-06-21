@extends('layouts.admin.admin')
@section('title', 'Sửa Voucher')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Sửa Voucher</h1>

    <form method="POST" action="{{ route('admin.vouchers.update', $voucher->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Mã code</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $voucher->code) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Kiểu giảm</label>
            <select name="discount_type" class="form-select">
                <option value="percentage" {{ $voucher->discount_type == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Cố định</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá trị giảm</label>
            <input type="number" name="discount_value" class="form-control" value="{{ old('discount_value', $voucher->discount_value) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Giảm tối đa</label>
            <input type="number" name="max_discount" class="form-control" value="{{ old('max_discount', $voucher->max_discount) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Đơn hàng tối thiểu</label>
            <input type="number" name="min_order_value" class="form-control" value="{{ old('min_order_value', $voucher->min_order_value) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $voucher->quantity) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <input type="text" name="description" class="form-control" value="{{ old('description', $voucher->description) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date', \Carbon\Carbon::parse($voucher->start_date)->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày kết thúc</label>
            <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', \Carbon\Carbon::parse($voucher->end_date)->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_hidden" value="1" id="hiddenCheck" {{ $voucher->is_hidden ? 'checked' : '' }}>
            <label class="form-check-label" for="hiddenCheck">Ẩn voucher</label>
        </div>

        <button class="btn btn-primary" type="submit">Cập nhật</button>
        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
