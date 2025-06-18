<nav class="bg-white border-b shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <a href="/admin/dashboard" class="flex items-center space-x-2">
                <img src="/logo.png" alt="Logo" class="h-8 w-auto" />
                <span class="text-xl font-bold text-gray-800">Admin Panel</span>
            </a>

            <!-- Navigation Links -->
            <div class="hidden sm:flex space-x-6">
                <a href="/admin/dashboard"
                   class="text-gray-700 hover:text-blue-600 font-medium {{ request()->is('admin/dashboard') ? 'underline' : '' }}">
                    Dashboard
                </a>
                <!-- Add more nav links here if needed -->
            </div>

            <!-- User Dropdown -->
            <div class="relative">
                <button id="user-menu-btn"
                        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                    <span id="user-name" class="font-medium">Loading...</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div id="dropdown-menu"
                     class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-md hidden z-10">
                    <a href="/profile/edit"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <button onclick="logout()"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>


<script>
    const token = localStorage.getItem('access_token');

    function loadUser() {
        const userNameEl = document.getElementById('user-name');

        if (!token) {
            userNameEl.innerText = 'Guest';
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
            userNameEl.innerText = user.name || 'User';
        })
        .catch(() => {
            userNameEl.innerText = 'Guest';
        });
    }

    function logout() {
        localStorage.removeItem('access_token');
        window.location.href = '/login';
    }

    // Toggle dropdown menu
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('user-menu-btn');
        const menu = document.getElementById('dropdown-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Ẩn dropdown nếu click ra ngoài
        document.addEventListener('click', (e) => {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        loadUser();
    });
</script>
