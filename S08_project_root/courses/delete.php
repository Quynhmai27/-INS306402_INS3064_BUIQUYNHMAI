require_once __DIR__ . '/../config/app.php';
<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    $db->delete('courses', 'id = ?', [$id]);
} catch (Exception $e) {
    // có thể log nếu cần
}

header('Location: index.php?deleted=1');
exit;