<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($fullname === '' || $username === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $message = 'Vui lòng nhập đầy đủ thông tin.';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Email không hợp lệ.';
        $messageType = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'Mật khẩu phải từ 6 ký tự trở lên.';
        $messageType = 'error';
    } elseif ($password !== $confirmPassword) {
        $message = 'Mật khẩu xác nhận không khớp.';
        $messageType = 'error';
    } elseif (findUserByEmail($email)) {
        $message = 'Email đã tồn tại.';
        $messageType = 'error';
    } elseif (findUserByUsername($username)) {
        $message = 'Tên đăng nhập đã tồn tại.';
        $messageType = 'error';
    } else {
        $users = loadUsers();

        $newUser = [
            'id' => uniqid('user_'),
            'fullname' => $fullname,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'bio' => 'Xin chào, tôi là sinh viên đang sử dụng hệ thống hồ sơ cá nhân.',
            'avatar' => '',
            'email_verified' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $users[] = $newUser;
        saveUsers($users);

        $message = 'Đăng ký thành công. Bây giờ bạn có thể đăng nhập.';
        $messageType = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - StudentProfile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <div class="auth-box">
        <div class="auth-card">
            <h1>Đăng ký tài khoản</h1>
            <p class="sub-text">Tạo tài khoản để vào hệ thống hồ sơ sinh viên</p>

            <?php if ($message): ?>
                <div class="alert <?= e($messageType) ?>"><?= e($message) ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <label>Họ tên</label>
                <input type="text" name="fullname" value="Bùi Quỳnh Mai" required>

                <label>Tên đăng nhập</label>
                <input type="text" name="username" value="quynhmai" required>

                <label>Email</label>
                <input type="email" name="email" value="quynhmai2708204@gmail.com" required>

                <label>Mật khẩu</label>
                <input type="password" name="password" value="123456" required>

                <label>Xác nhận mật khẩu</label>
                <input type="password" name="confirm_password" value="123456" required>

                <button type="submit" class="btn primary full">Đăng ký</button>
            </form>

            <p class="switch-link">
                Đã có tài khoản? <a href="login.php">Đăng nhập</a>
            </p>
        </div>
    </div>
</body>
</html>