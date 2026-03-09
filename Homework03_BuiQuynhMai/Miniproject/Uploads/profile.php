<?php
require_once 'config.php';
requireLogin();

$user = getCurrentUser();

if (!$user) {
    session_unset();
    session_destroy();
    redirect('login.php');
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    if ($fullname === '' || $username === '') {
        $message = 'Họ tên và username không được để trống.';
        $messageType = 'error';
    } else {
        $existingUsername = findUserByUsername($username);
        if ($existingUsername && $existingUsername['id'] !== $user['id']) {
            $message = 'Username đã được sử dụng.';
            $messageType = 'error';
        } else {
            $user['fullname'] = $fullname;
            $user['username'] = $username;
            $user['bio'] = $bio;
            $user['updated_at'] = date('Y-m-d H:i:s');

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                $fileType = mime_content_type($_FILES['avatar']['tmp_name']);

                if (in_array($fileType, $allowed)) {
                    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                    $newName = uniqid('avatar_') . '.' . $ext;
                    $targetPath = UPLOAD_DIR . $newName;

                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                        $user['avatar'] = $newName;
                    } else {
                        $message = 'Upload ảnh thất bại.';
                        $messageType = 'error';
                    }
                } else {
                    $message = 'Chỉ chấp nhận file JPG, PNG, WEBP.';
                    $messageType = 'error';
                }
            }

            if ($messageType !== 'error') {
                updateUser($user);
                $_SESSION['user_id'] = $user['id'];
                $message = 'Cập nhật hồ sơ thành công.';
                $messageType = 'success';
            }
        }
    }
}

$avatar = !empty($user['avatar'])
    ? 'uploads/' . $user['avatar']
    : 'https://ui-avatars.com/api/?name=' . urlencode($user['fullname']) . '&background=6d5efc&color=fff&size=200';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân - StudentProfile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <header class="navbar">
        <div class="brand">🎓 StudentProfile</div>
        <div class="nav-right">
            <a href="dashboard.php" class="btn small light">Dashboard</a>
            <a href="logout.php" class="btn small danger">Đăng xuất</a>
        </div>
    </header>

    <main class="container">
        <div class="form-panel large">
            <h1>Chỉnh sửa hồ sơ</h1>
            <p class="sub-text">Cập nhật thông tin cá nhân của bạn</p>

            <?php if ($message): ?>
                <div class="alert <?= e($messageType) ?>"><?= e($message) ?></div>
            <?php endif; ?>

            <div class="profile-preview">
                <img src="<?= e($avatar) ?>" alt="avatar" class="avatar big">
            </div>

            <form method="POST" enctype="multipart/form-data" class="auth-form">
                <label>Họ tên</label>
                <input type="text" name="fullname" value="<?= e($user['fullname']) ?>" required>

                <label>Username</label>
                <input type="text" name="username" value="<?= e($user['username']) ?>" required>

                <label>Email</label>
                <input type="email" value="<?= e($user['email']) ?>" disabled>

                <label>Tiểu sử</label>
                <textarea name="bio" rows="5" placeholder="quinmeii"><?= e($user['bio']) ?></textarea>

                <label>Ảnh đại diện</label>
                <input type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp">

                <button type="submit" class="btn primary full">Lưu thay đổi</button>
            </form>
        </div>
    </main>
</body>
</html>