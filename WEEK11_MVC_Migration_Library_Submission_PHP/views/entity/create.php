<?php require __DIR__ . '/partials/header.php'; ?>

<h1>Add New</h1>

<form method="POST" action="index.php?action=store">
    <label>Name:</label>
    <input type="text" name="name" required>
    <br><br>
    <button type="submit">Save</button>
    <a href="index.php?action=index">Cancel</a>
</form>