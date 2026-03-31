<?php
// index.php
include('config.php'); // Kết nối tới cơ sở dữ liệu

// Truy vấn tất cả sách từ bảng books
$query = "SELECT * FROM books";
$stmt = $pdo->prepare($query);
$stmt->execute(); // Thực thi truy vấn
$books = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy tất cả kết quả

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
</head>
<body>

<h1>Library Dashboard</h1>

<!-- Form thêm sách mới -->
<h2>Add New Book</h2>
<form action="add_book.php" method="POST">
    <label>ISBN:</label><input type="text" name="isbn" required><br>
    <label>Title:</label><input type="text" name="title" required><br>
    <label>Author:</label><input type="text" name="author" required><br>
    <label>Publisher:</label><input type="text" name="publisher"><br>
    <label>Year:</label><input type="number" name="publication_year"><br>
    <label>Available Copies:</label><input type="number" name="available_copies" required><br>
    <button type="submit">Add Book</button>
</form>

<!-- Danh sách sách -->
<h2>Books List</h2>
<table border="1">
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
        <td><?php echo $book['id']; ?></td>
        <td><?php echo $book['isbn']; ?></td>
        <td><?php echo $book['title']; ?></td>
        <td><?php echo $book['author']; ?></td>
        <td><?php echo $book['publisher']; ?></td>
        <td><?php echo $book['publication_year']; ?></td>
        <td><?php echo $book['available_copies']; ?></td>
        <td>
            <a href="edit_book.php?id=<?php echo $book['id']; ?>">Edit</a> |
            <a href="delete_book.php?id=<?php echo $book['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>