CREATE DATABASE IF NOT EXISTS library_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE library_db;

DROP TABLE IF EXISTS borrow_transactions;
DROP TABLE IF EXISTS books;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    title VARCHAR(150) NOT NULL,
    author VARCHAR(100) NOT NULL,
    publisher VARCHAR(100) NULL,
    publication_year INT NULL,
    available_copies INT NOT NULL
);

CREATE TABLE borrow_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    borrower_name VARCHAR(100) NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE NULL,
    status ENUM('Borrowed', 'Returned', 'Overdue') NOT NULL DEFAULT 'Borrowed',
    CONSTRAINT fk_borrow_book FOREIGN KEY (book_id)
        REFERENCES books(id) ON DELETE CASCADE
);

INSERT INTO books (isbn, title, author, publisher, publication_year, available_copies) VALUES
('9780131103627', 'The C Programming Language', 'Brian W. Kernighan', 'Prentice Hall', 1988, 4),
('9780132350884', 'Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, 5),
('9780201633610', 'Design Patterns', 'Erich Gamma', 'Addison-Wesley', 1994, 3),
('9780134685991', 'Effective Java', 'Joshua Bloch', 'Addison-Wesley', 2018, 6),
('9781491950357', 'Learning PHP, MySQL & JavaScript', 'Robin Nixon', "O'Reilly Media", 2018, 7),
('9781617296086', 'Spring in Action', 'Craig Walls', 'Manning', 2022, 2),
('9780596007126', 'Head First Design Patterns', 'Eric Freeman', "O'Reilly Media", 2004, 4),
('9780134494166', 'Clean Architecture', 'Robert C. Martin', 'Prentice Hall', 2017, 3),
('9780262033848', 'Introduction to Algorithms', 'Thomas H. Cormen', 'MIT Press', 2009, 8),
('9780135974445', 'Database Systems', 'Thomas Connolly', 'Pearson', 2019, 5);

INSERT INTO borrow_transactions (book_id, borrower_name, borrow_date, due_date, return_date, status) VALUES
(1, 'Nguyen Van A', '2026-03-01', '2026-03-15', '2026-03-12', 'Returned'),
(2, 'Tran Thi B', '2026-03-05', '2026-03-19', NULL, 'Borrowed'),
(3, 'Le Minh C', '2026-02-20', '2026-03-05', NULL, 'Overdue'),
(4, 'Pham Thu D', '2026-03-08', '2026-03-22', NULL, 'Borrowed'),
(5, 'Hoang Anh E', '2026-02-25', '2026-03-10', '2026-03-09', 'Returned'),
(6, 'Do Quang F', '2026-03-03', '2026-03-17', NULL, 'Borrowed'),
(7, 'Bui Ngoc G', '2026-02-18', '2026-03-04', NULL, 'Overdue'),
(8, 'Vu Hai H', '2026-03-06', '2026-03-20', NULL, 'Borrowed'),
(9, 'Dang Lan I', '2026-02-28', '2026-03-14', '2026-03-13', 'Returned'),
(10, 'Ngo Tuan K', '2026-03-09', '2026-03-23', NULL, 'Borrowed');