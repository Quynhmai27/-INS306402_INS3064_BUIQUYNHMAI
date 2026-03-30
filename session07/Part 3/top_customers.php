<?php
require_once 'Database.php';

$db = Database::getInstance()->getConnection();

// 1. Prepare + execute
$sql = "SELECT 
            u.name,
            u.email,
            SUM(o.total_amount) AS total_spent
        FROM users u
        JOIN orders o ON u.id = o.user_id
        GROUP BY u.id
        ORDER BY total_spent DESC
        LIMIT 3";

$stmt = $db->prepare($sql);
$stmt->execute();

// 2. Fetch data
$customers = $stmt->fetchAll();
?>

<!-- HTML -->
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Total Spent</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo $row['total_spent']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>