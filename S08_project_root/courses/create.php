require_once __DIR__ . '/../config/app.php';
<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/ValidationException.php';

$db = Database::getInstance();

$errors = [];
$title = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    try {
        // VALIDATE
        if ($title === '') {
            throw new ValidationException('Tên khóa học không được để trống');
        }
        if (strlen($title) < 3) {
            throw new ValidationException('Tên khóa học phải ≥ 3 ký tự');
        }

        // INSERT
        $db->insert('courses', [
            'title' => $title,
            'description' => $description
        ]);

        header('Location: index.php?success=1');
        exit;

    } catch (ValidationException $e) {
        $errors['general'] = $e->getMessage();
    } catch (Exception $e) {
        $errors['general'] = 'Lỗi hệ thống';
    }
}
?>

<h1>Thêm khóa học</h1>

<?php if (!empty($errors['general'])): ?>
<p style="color:red"><?= $errors['general'] ?></p>
<?php endif; ?>

<form method="post">
Tên khóa học:<br>
<input type="text" name="title" value="<?= htmlspecialchars($title) ?>"><br><br>

Mô tả:<br>
<textarea name="description"><?= htmlspecialchars($description) ?></textarea><br><br>

<button>Lưu</button>
</form>