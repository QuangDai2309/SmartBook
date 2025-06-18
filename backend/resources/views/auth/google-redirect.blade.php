<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đang chuyển hướng...</title>
</head>
<body>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('access_token');

        if (token) {
            // Lưu token vào localStorage
            localStorage.setItem('access_token', token);

            // ✅ Sau đó chuyển hướng tới trang admin
            window.location.href = "/admin/dashboard";
        } else {
            document.body.innerText = "Không tìm thấy access token!";
        }
    </script>
</body>
</html>
