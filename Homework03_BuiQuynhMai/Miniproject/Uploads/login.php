<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $message = 'Vui lòng nhập đầy đủ thông tin.';
        $messageType = 'error';
    } else {
        $user = findUserByEmail($login);

        if (!$user) {
            $user = findUserByUsername($login);
        }

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            redirect('dashboard.php');
        } else {
            $message = 'Sai tài khoản hoặc mật khẩu.';
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - StudentProfile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <div class="auth-box">
        <div class="auth-card">
            <h1>Đăng nhập</h1>
            <p class="sub-text">Chào mừng bạn quay lại hệ thống</p>

            <?php if ($message): ?>
                <div class="alert <?= e($messageType) ?>"><?= e($message) ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <label>Email hoặc username</label>
                <input type="text" name="login" placeholder="Nhập email hoặc username" required>

                <label>Mật khẩu</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu" required>

                <button type="submit" class="btn primary full">Đăng nhập</button>
            </form>

            <div class="demo-box">
                <strong>Tài khoản mẫu</strong>
                <p>Username: quynhmai</p>
                <p>Email: quynhmai2708204@gmail.com</p>
                <p>Password: 123456</p>
            </div>

            <p class="switch-link">
                Chưa có tài khoản? <a href="register.php">Đăng ký</a>
            </p>
        </div>
    </div>
</body>
</html>