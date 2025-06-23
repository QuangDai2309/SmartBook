<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Google</title>
</head>
<body>
    <script>
        // Lấy token từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('access_token');

        if (token) {
            localStorage.setItem('access_token', token);
            window.location.href = "/admin/dashboard";
        } else {
            document.body.innerText = "Không tìm thấy access token!";
        }
    </script>
</body>
</html>
