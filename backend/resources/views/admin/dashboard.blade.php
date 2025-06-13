@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4 fw-bold text-primary"><i class="bi bi-speedometer2"></i> Trang Quản Trị</h1>

        {{-- Thống kê nhanh --}}
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow border-0 bg-gradient bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">📚 Tổng số sách</h6>
                        <h2 class="card-title">{{ \App\Models\Book::count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 bg-gradient bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">👤 Tác giả</h6>
                        <h2 class="card-title">{{ \App\Models\Author::count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 bg-gradient bg-warning text-dark">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">🏢 Nhà xuất bản</h6>
                        <h2 class="card-title">{{ \App\Models\Publisher::count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 bg-gradient bg-danger text-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">📂 Danh mục</h6>
                        <h2 class="card-title">{{ \App\Models\Category::count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Biểu đồ lượt xem theo danh mục --}}
        <div class="mt-5">
            <h4><i class="bi bi-pie-chart-fill"></i> Lượt xem theo danh mục</h4>
           <canvas id="viewsChart" style="max-height: 300px;"></canvas>
        </div>

        {{-- Danh sách sách mới nhất --}}
        <div class="mt-5">
            <h4><i class="bi bi-book-half"></i> Sách mới thêm gần đây</h4>
            <ul class="list-group shadow-sm">
                @foreach ($recentBooks as $book)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <strong>{{ $book->title }}</strong>
                            <small class="text-muted">({{ $book->created_at->format('d/m/Y') }})</small>
                        </span>
                        <span class="badge bg-primary">{{ $book->views }} 👁️</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Biểu đồ số lượng sách theo nhà xuất bản --}}
        <div class="mt-5">
            <h4><i class="bi bi-bar-chart"></i> Sách theo nhà xuất bản</h4>
            <canvas id="publisherChart" style="max-height: 300px;"></canvas>
        </div>

        {{-- Thư viện Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Lượt xem theo danh mục
            const viewsCtx = document.getElementById('viewsChart').getContext('2d');
            new Chart(viewsCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($viewsByCategory->pluck('label')) !!},
                    datasets: [{
                        label: 'Lượt xem',
                        data: {!! json_encode($viewsByCategory->pluck('views')) !!},
                        backgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Sách theo nhà xuất bản
            const publisherCtx = document.getElementById('publisherChart').getContext('2d');
            new Chart(publisherCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($booksByPublisher->pluck('name')) !!},
                    datasets: [{
                        label: 'Số lượng sách',
                        data: {!! json_encode($booksByPublisher->pluck('books_count')) !!},
                        backgroundColor: [
                            '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>

        {{-- Thống kê phụ --}}
        <div class="mt-5">
            <h4 class="mb-3"><i class="bi bi-bar-chart-line-fill"></i> Thống kê nhanh</h4>
            <ul class="list-group list-group-flush shadow-sm">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    🖼 Tổng banner:
                    <span class="badge bg-info rounded-pill">{{ \App\Models\Banner::count() }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    📈 Tổng lượt xem sách:
                    <span class="badge bg-secondary rounded-pill">{{ \App\Models\Book::sum('views') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ❤️ Tổng lượt thích sách:
                    <span class="badge bg-danger rounded-pill">{{ \App\Models\Book::sum('likes') }}</span>
                </li>
            </ul>
        </div>
    </div>
@endsection
