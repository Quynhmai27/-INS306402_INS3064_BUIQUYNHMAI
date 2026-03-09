<?php
require_once 'config.php';
requireLogin();

$user = getCurrentUser();

if (!$user) {
    session_unset();
    session_destroy();
    redirect('login.php');
}

$days = daysAsMember($user['created_at']);
$bioLen = bioLength($user['bio']);
$hasAvatar = !empty($user['avatar']);
$avatar = $hasAvatar ? 'uploads/' . $user['avatar'] : 'https://ui-avatars.com/api/?name=' . urlencode($user['fullname']) . '&background=6d5efc&color=fff&size=200';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - StudentProfile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <header class="navbar">
        <div class="brand">🎓 StudentProfile</div>
        <div class="nav-right">
            <span class="welcome-name"><?= e($user['fullname']) ?></span>
            <a href="profile.php" class="btn small light">Sửa hồ sơ</a>
            <a href="logout.php" class="btn small danger">Đăng xuất</a>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <div class="hero-left">
                <img src="<?= e($avatar) ?>" alt="Avatar" class="avatar">
            </div>
            <div class="hero-right">
                <h1>Chào, <?= e($user['fullname']) ?>! 👋</h1>
                <p class="hero-meta">@<?= e($user['username']) ?> · Tham gia <?= $days ?> ngày trước</p>
                <p class="hero-bio"><?= nl2br(e($user['bio'])) ?></p>
            </div>
        </section>

        <section class="stats">
            <div class="stat-card">
                <h3><?= $days ?></h3>
                <p>Ngày là thành viên</p>
            </div>
            <div class="stat-card">
                <h3><?= $user['email_verified'] ? '1' : '0' ?></h3>
                <p>Email đã xác nhận</p>
            </div>
            <div class="stat-card">
                <h3><?= $bioLen ?></h3>
                <p>Ký tự trong tiểu sử</p>
            </div>
            <div class="stat-card">
                <h3><?= $hasAvatar ? '✓' : '✕' ?></h3>
                <p>Ảnh đại diện</p>
            </div>
        </section>

        <section class="grid-2">
            <div class="panel">
                <h2>⚡ Thao tác nhanh</h2>

                <a href="profile.php" class="action-box">
                    <div>
                        <strong>Chỉnh sửa hồ sơ</strong>
                        <p>Cập nhật họ tên, username, bio, ảnh đại diện</p>
                    </div>
                    <span>→</span>
                </a>

                <a href="logout.php" class="action-box">
                    <div>
                        <strong>Đăng xuất</strong>
                        <p>Kết thúc phiên làm việc an toàn</p>
                    </div>
                    <span>→</span>
                </a>
            </div>

            <div class="panel">
                <h2>👤 Thông tin tài khoản</h2>

                <div class="info-row">
                    <span>Họ tên</span>
                    <strong><?= e($user['fullname']) ?></strong>
                </div>

                <div class="info-row">
                    <span>Username</span>
                    <strong>@<?= e($user['username']) ?></strong>
                </div>

                <div class="info-row">
                    <span>Email</span>
                    <strong><?= e($user['email']) ?></strong>
                </div>

                <div class="info-row">
                    <span>Ngày tạo</span>
                    <strong><?= e(date('d/m/Y H:i', strtotime($user['created_at']))) ?></strong>
                </div>

                <div class="info-row">
                    <span>Ảnh đại diện</span>
                    <strong><?= $hasAvatar ? 'Đã có' : 'Chưa có' ?></strong>
                </div>
            </div>
        </section>
    </main>
</body>
</html>