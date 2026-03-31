<?php
// config.php

// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost'; // Địa chỉ máy chủ MySQL
$dbname = 'library_db'; // Tên cơ sở dữ liệu
$username = 'root'; // Tên người dùng MySQL
$password = ''; // Mật khẩu MySQL

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Thiết lập chế độ báo lỗi
} catch (PDOException $e) {
    // Nếu không thể kết nối, hiển thị thông báo lỗi
    echo "Connection failed: " . $e->getMessage();
}
?>