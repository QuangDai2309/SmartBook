<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang quản trị')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
   {{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin1</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.books.index') }}">Sách</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.authors.index') }}">Tác giả</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.publishers.index') }}">NXB</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.categories.index') }}">Danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.banners.index') }}">Banner</a></li>
            </ul>

            {{-- Dropdown người dùng --}}
            <div class="ms-auto text-white d-flex align-items-center">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        👤 <span id="user-name">Loading...</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" id="logout-btn">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>


    {{-- Nội dung chính --}}
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script gọi API /api/me --}}
   <script>
    document.addEventListener('DOMContentLoaded', () => {
        const userNameEl = document.getElementById('user-name');
        const token = localStorage.getItem('access_token');

        if (!token) {
            userNameEl.innerText = 'Khách';
            return;
        }

        fetch('/api/me', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Unauthorized');
            return res.json();
        })
        .then(user => {
            userNameEl.innerText = user?.user?.name || 'Người dùng';
        })
        .catch(err => {
            console.error('Lỗi khi gọi /api/me:', err);
            userNameEl.innerText = 'Khách';
        });

        // Bắt sự kiện logout
        const logoutBtn = document.getElementById('logout-btn');
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            localStorage.removeItem('access_token');
            window.location.href = '/login'; // hoặc route login của mày
        });
    });
</script>


    @stack('scripts')
</body>
</html>
