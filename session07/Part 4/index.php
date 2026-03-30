<?php
require_once 'Database.php';

$db = Database::getInstance()->getConnection();

// Lấy dữ liệu filter
$search = $_GET['search'] ?? '';
$category_id = $_GET['category'] ?? '';

// Lấy danh sách categories cho dropdown
$cat_stmt = $db->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll();

// Query chính
$sql = "SELECT 
            p.id,
            p.name,
            p.price,
            p.stock,
            c.category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE 1=1";

$params = [];

// Search theo name
if (!empty($search)) {
    $sql .= " AND p.name LIKE :search";
    $params[':search'] = "%$search%";
}

// Filter theo category
if (!empty($category_id)) {
    $sql .= " AND p.category_id = :category";
    $params[':category'] = $category_id;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);

$products = $stmt->fetchAll();
?>

<!-- FORM SEARCH + FILTER -->
<form method="GET">
    <input type="text" name="search" placeholder="Search product..." value="<?php echo htmlspecialchars($search); ?>">

    <select name="category">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?php echo $cat['id']; ?>" 
                <?php if ($category_id == $cat['id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($cat['category_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filter</button>
</form>

<br>

<!-- TABLE -->
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
            <tr style="<?php echo ($p['stock'] < 10) ? 'background-color: red;' : ''; ?>">
                <td><?php echo $p['id']; ?></td>
                <td><?php echo htmlspecialchars($p['name']); ?></td>
                <td><?php echo $p['price']; ?></td>
                <td><?php echo $p['category_name'] ?? 'NULL'; ?></td>
                <td><?php echo $p['stock']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>