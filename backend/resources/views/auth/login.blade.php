<x-guest-layout>
    <div id="login-status" class="mb-4 text-red-600"></div>

    <form id="login-form">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
        </div>

        <!-- Remember -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600" />
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Đăng nhập</button>
        </div>

        <!-- Google -->
        <div class="mt-4">
            <button type="button" id="google-login-btn" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48"><path fill="#fff" d="..." /></svg>
                Đăng nhập bằng Google
            </button>
        </div>
    </form>

    <script>
        const loginForm = document.getElementById('login-form');
        const loginStatus = document.getElementById('login-status');

        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const res = await fetch('/api/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ email, password })
});

const data = await res.json();
if (data.status) {
    localStorage.setItem('access_token', data.access_token);
    window.location.href = '/admin/dashboard';
}

 
        });

        document.getElementById('google-login-btn').addEventListener('click', async function () {
            window.location.href = `/api/login/google`;
        });
    </script>
</x-guest-layout>
