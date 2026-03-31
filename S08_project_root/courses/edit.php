require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$errors = [];

// Lấy khóa học hiện tại
$course = $db->fetch('SELECT * FROM courses WHERE id = ?', [$id]);
if (!$course) {
    header('Location: index.php');
    exit;
}

$title = $course['title'];
$code  = $course['code'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $code  = trim($_POST['code'] ?? '');

    if ($title === '') $errors['title'] = 'Vui lòng nhập tên khóa học.';
    if ($code === '')  $errors['code']  = 'Vui lòng nhập mã khóa học.';

    if (empty($errors)) {
        try {
            // Check trùng code (trừ chính nó)
            $existing = $db->fetch(
                'SELECT id FROM courses WHERE code = ? AND id <> ?',
                [$code, $id]
            );

            if ($existing) {
                $errors['code'] = 'Mã khóa học đã tồn tại.';
            } else {
                $db->update('courses', [
                    'title' => $title,
                    'code'  => $code
                ], 'id = ?', [$id]);

                header('Location: index.php?updated=1');
                exit;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa khóa học</title>
</head>
<body>

<h1>Sửa khóa học</h1>

<form method="post">

<div>
<label>Tên khóa học:</label><br>
<input type="text" name="title" value="<?= htmlspecialchars($title) ?>">
<?php if (!empty($errors['title'])): ?>
<span style="color:red"><?= htmlspecialchars($errors['title']) ?></span>
<?php endif; ?>
</div>

<div>
<label>Mã khóa học:</label><br>
<input type="text" name="code" value="<?= htmlspecialchars($code) ?>">
<?php if (!empty($errors['code'])): ?>
<span style="color:red"><?= htmlspecialchars($errors['code']) ?></span>
<?php endif; ?>
</div>

<br>
<button type="submit">Cập nhật</button>
<a href="index.php">Hủy</a>

</form>

</body>
</html>