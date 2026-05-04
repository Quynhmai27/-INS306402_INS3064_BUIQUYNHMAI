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