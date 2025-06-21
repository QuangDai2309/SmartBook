@extends('layouts.admin.admin')
@section('title', 'Thêm Voucher')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Thêm Mã Giảm Giá</h1>

    {{-- Hiển thị lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Có lỗi xảy ra:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.vouchers.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Mã code *</label>
            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kiểu giảm giá *</label>
            <select name="discount_type" class="form-select" required>
                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Cố định</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá trị giảm *</label>
            <input type="number" name="discount_value" class="form-control" value="{{ old('discount_value') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giảm tối đa (nếu là phần trăm)</label>
            <input type="number" name="max_discount" class="form-control" value="{{ old('max_discount') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Đơn hàng tối thiểu *</label>
            <input type="number" name="min_order_value" class="form-control" value="{{ old('min_order_value') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số lượng còn lại *</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <input type="text" name="description" class="form-control" value="{{ old('description') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày bắt đầu *</label>
            <input type="datetime-local" name="start_date" class="form-control"
                   value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày kết thúc *</label>
            <input type="datetime-local" name="end_date" class="form-control"
                   value="{{ old('end_date', now()->addDays(7)->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_hidden" value="1" id="hiddenCheck"
                {{ old('is_hidden') ? 'checked' : '' }}>
            <label class="form-check-label" for="hiddenCheck">
                Ẩn voucher
            </label>
        </div>

        <button class="btn btn-success" type="submit">Thêm Voucher</button>
        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
