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

<?php
// edit_book.php
include('config.php');

// Lấy ID của sách cần sửa
$id = $_GET['id'];

// Truy vấn để lấy thông tin sách
$query = "SELECT * FROM books WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$book = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra nếu form đã được submit để cập nhật sách
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'];
    $available_copies = $_POST['available_copies'];

    $update_query = "UPDATE books SET isbn = :isbn, title = :title, author = :author, publisher = :publisher, 
                     publication_year = :publication_year, available_copies = :available_copies WHERE id = :id";
    
    $stmt = $pdo->prepare($update_query);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':publisher', $publisher);
    $stmt->bindParam(':publication_year', $publication_year);
    $stmt->bindParam(':available_copies', $available_copies);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Book updated successfully!";
    } else {
        echo "Error updating book.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
</head>
<body>

<h1>Edit Book</h1>
<form action="edit_book.php?id=<?php echo $id; ?>" method="POST">
    <label>ISBN:</label><input type="text" name="isbn" value="<?php echo $book['isbn']; ?>" required><br>
    <label>Title:</label><input type="text" name="title" value="<?php echo $book['title']; ?>" required><br>
    <label>Author:</label><input type="text" name="author" value="<?php echo $book['author']; ?>" required><br>
    <label>Publisher:</label><input type="text" name="publisher" value="<?php echo $book['publisher']; ?>"><br>
    <label>Year:</label><input type="number" name="publication_year" value="<?php echo $book['publication_year']; ?>"><br>
    <label>Available Copies:</label><input type="number" name="available_copies" value="<?php echo $book['available_copies']; ?>" required><br>
    <button type="submit">Update Book</button>
</form>

</body>
</html>

<?php
// delete_book.php
include('config.php');

$id = $_GET['id']; // Lấy ID của sách cần xóa

// Truy vấn để xóa sách từ cơ sở dữ liệu
$query = "DELETE FROM books WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    echo "Book deleted successfully!";
} else {
    echo "Error deleting book.";
}
?>

<?php
// create.php
include('config.php');

// Kiểm tra nếu form đã được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'];
    $available_copies = $_POST['available_copies'];

    // Truy vấn SQL để thêm sách vào cơ sở dữ liệu
    $query = "INSERT INTO books (isbn, title, author, publisher, publication_year, available_copies)
              VALUES (:isbn, :title, :author, :publisher, :publication_year, :available_copies)";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':isbn', $isbn);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':publisher', $publisher);
    $stmt->bindParam(':publication_year', $publication_year);
    $stmt->bindParam(':available_copies', $available_copies);

    // Thực thi truy vấn
    if ($stmt->execute()) {
        echo "Book added successfully!";
    } else {
        echo "Error adding book.";
    }
}
?>

<?php
// config.php

// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost'; // Địa chỉ máy chủ MySQL
$dbname = 'library_db'; // Tên cơ sở dữ liệu
$username = 'root'; // Tên người dùng MySQL
$password = ''; // Mật khẩu MySQL

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Thiết lập chế độ báo lỗi
} catch (PDOException $e) {
    // Nếu không thể kết nối, hiển thị thông báo lỗi
    echo "Connection failed: " . $e->getMessage();
}
?>