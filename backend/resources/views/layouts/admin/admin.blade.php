<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<body>
    <div class="d-flex" style="min-height: 100vh;">
        {{-- Sidebar --}}
        <nav class="bg-dark text-white p-3" style="width: 250px;">
            <h4 class="text-white mb-4">SmartBook</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->is('admin/dashboard') ? 'active bg-secondary' : '' }}"
                        href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->is('admin/books*') ? 'active bg-secondary' : '' }}"
                        href="{{ route('admin.books.index') }}">📚 Quản lý Sách</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->is('admin/authors*') ? 'active bg-secondary' : '' }}"
                        href="{{ route('admin.authors.index') }}">👨‍💼 Tác giả</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->is('admin/publishers*') ? 'active bg-secondary' : '' }}"
                        href="{{ route('admin.publishers.index') }}">🏢 NXB</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->is('admin/book_categories*') ? 'active bg-secondary' : '' }}"
                        href="{{ route('admin.book_categories.index') }}">📂 Danh mục Sách</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white {{ request()->is('admin/tags*') ? 'active bg-secondary' : '' }}"
                        href="{{ route('admin.tags.index') }}">📌 Thẻ sách
                    </a>
                </li>

            </ul>
        </nav>

        {{-- Main content --}}
        <div class="flex-grow-1 p-4 bg-light">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>

</html>
