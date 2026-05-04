<?php

require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$errors = [];

try {
    $book = $db->fetch('SELECT * FROM books WHERE id = ?', [$id]);
    if (!$book) {
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    die('Cannot load book data.');
}

$isbn = $book['isbn'];
$title = $book['title'];
$author = $book['author'];
$publisher = $book['publisher'];
$publication_year = $book['publication_year'];
$available_copies = $book['available_copies'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = trim($_POST['isbn'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $publisher = trim($_POST['publisher'] ?? '');
    $publication_year = trim($_POST['publication_year'] ?? '');
    $available_copies = trim($_POST['available_copies'] ?? '');

    if ($isbn === '') {
        $errors['isbn'] = 'ISBN is required.';
    }

    if ($title === '') {
        $errors['title'] = 'Title is required.';
    }

    if ($author === '') {
        $errors['author'] = 'Author is required.';
    }

    if ($available_copies === '') {
        $errors['available_copies'] = 'Available copies is required.';
    } elseif (!is_numeric($available_copies) || (int)$available_copies < 0) {
        $errors['available_copies'] = 'Available copies must be a non-negative number.';
    }

    if ($publication_year !== '' && (!is_numeric($publication_year) || (int)$publication_year < 0)) {
        $errors['publication_year'] = 'Publication year must be a valid number.';
    }

    if (empty($errors)) {
        try {
            $existing = $db->fetch('SELECT id FROM books WHERE isbn = ? AND id <> ?', [$isbn, $id]);

            if ($existing) {
                $errors['isbn'] = 'ISBN already exists for another book.';
            } else {
                $db->update('books', [
                    'isbn' => $isbn,
                    'title' => $title,
                    'author' => $author,
                    'publisher' => $publisher !== '' ? $publisher : null,
                    'publication_year' => $publication_year !== '' ? (int)$publication_year : null,
                    'available_copies' => (int)$available_copies,
                ], 'id = ?', [$id]);

                header('Location: index.php?updated=1');
                exit;
            }
        } catch (Exception $e) {
            $errors['general'] = 'Something went wrong. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Book</h1>

        <?php if (!empty($errors['general'])): ?>
            <div class="message message-error"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" value="<?= htmlspecialchars((string)$isbn) ?>">
                <?php if (!empty($errors['isbn'])): ?>
                    <span class="error-text"><?= htmlspecialchars($errors['isbn']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars((string)$title) ?>">
                <?php if (!empty($errors['title'])): ?>
                    <span class="error-text"><?= htmlspecialchars($errors['title']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" value="<?= htmlspecialchars((string)$author) ?>">
                <?php if (!empty($errors['author'])): ?>
                    <span class="error-text"><?= htmlspecialchars($errors['author']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Publisher</label>
                <input type="text" name="publisher" value="<?= htmlspecialchars((string)$publisher) ?>">
            </div>

            <div class="form-group">
                <label>Publication Year</label>
                <input type="number" name="publication_year" value="<?= htmlspecialchars((string)$publication_year) ?>">
                <?php if (!empty($errors['publication_year'])): ?>
                    <span class="error-text"><?= htmlspecialchars($errors['publication_year']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Available Copies</label>
                <input type="number" name="available_copies" value="<?= htmlspecialchars((string)$available_copies) ?>">
                <?php if (!empty($errors['available_copies'])): ?>
                    <span class="error-text"><?= htmlspecialchars($errors['available_copies']) ?></span>
                <?php endif; ?>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>