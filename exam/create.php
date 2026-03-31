<?php
// add_book.php
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