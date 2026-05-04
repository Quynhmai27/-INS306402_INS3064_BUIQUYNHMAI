<?php

require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();
$books = $db->fetchAll('SELECT * FROM books ORDER BY id DESC');

$message = '';
if (isset($_GET['success'])) {
    $message = 'Book added successfully.';
} elseif (isset($_GET['updated'])) {
    $message = 'Book updated successfully.';
} elseif (isset($_GET['deleted'])) {
    $message = 'Book deleted successfully.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <h1>Books Dashboard</h1>
            <div class="actions">
                <a href="../index.php" class="btn btn-secondary">Back Home</a>
                <a href="create.php" class="btn btn-success">+ Add Book</a>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="message message-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="table-wrap">
            <table>
                <tr>
                    <th>ID</th>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>Available Copies</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= $book['id'] ?></td>
                        <td><?= htmlspecialchars($book['isbn']) ?></td>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['publisher']) ?></td>
                        <td><?= htmlspecialchars((string)$book['publication_year']) ?></td>
                        <td><?= htmlspecialchars((string)$book['available_copies']) ?></td>
                        <td>
                            <div class="actions">
                                <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $book['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>