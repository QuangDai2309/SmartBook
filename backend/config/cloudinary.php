<?php

$config = [
    'url' => env('CLOUDINARY_URL'),

    'cloud' => env('CLOUDINARY_CLOUD_NAME'),
    'key' => env('CLOUDINARY_API_KEY'),
    'secret' => env('CLOUDINARY_API_SECRET'),
    'secure' => env('CLOUDINARY_SECURE', true),

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
];

// Debug ra xem các giá trị này là gì
// Khi chạy php artisan config:clear thì bạn xem lại kết quả log hoặc dump
// Bạn có thể tạm thời dùng dd để test:

return $config;
