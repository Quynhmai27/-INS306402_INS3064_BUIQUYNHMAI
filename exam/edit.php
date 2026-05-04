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