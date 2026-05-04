<?php require __DIR__ . '/partials/header.php'; ?>

<h1>Edit</h1>

<form method="POST" action="index.php?action=update">
    <input type="hidden" name="id" value="<?= htmlspecialchars($record['id']) ?>">

    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($record['name']) ?>" required>
    
    <br><br>
    <button type="submit">Update</button>
    <a href="index.php?action=index">Cancel</a>
</form>