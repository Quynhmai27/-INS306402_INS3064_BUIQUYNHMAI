<?php require __DIR__ . '/partials/header.php'; ?>

<h1>List</h1>
<a href="index.php?action=create">Add</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($records as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['id']) ?></td>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td>
                <a href="index.php?action=edit&id=<?= $r['id'] ?>">Edit</a>
                <a href="index.php?action=delete&id=<?= $r['id'] ?>"
                   onclick="return confirm('Delete this record?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>