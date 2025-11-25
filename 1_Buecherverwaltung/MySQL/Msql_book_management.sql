/*
    Book Management System - MySQL Version for phpMyAdmin
*/



-- DATABASE: BOOK_MANAGEMENT
DROP DATABASE IF EXISTS book_management;
CREATE DATABASE book_management;

-- USE DATABASE
USE book_management;



-- TABLE: BOOK 
DROP TABLE IF EXISTS book;
CREATE TABLE book (
  book_id INT AUTO_INCREMENT PRIMARY KEY,
  isbn_number VARCHAR(17) NOT NULL,
	title VARCHAR(250) NOT NULL,
  author VARCHAR(150) NOT NULL,
  genre VARCHAR(100)
);


-- CREATE BOOK SAMPLES
INSERT INTO book (isbn_number, title, author, genre) VALUES
  ('978-3-608-96376-2', 'Der Herr der Ringe', 'J. R. R. Tolkien', 'Fantasy'),
  ('978-3-596-90400-9', 'Die Verwandlung', 'Franz Kafka', 'Novelle'),
  ('978-3-551-55741-2', 'Harry Potter und der Stein der Weisen', 'J. K. Rowling', 'Fantasy'),
  ('978-3-548-23128-2', '1984', 'George Orwell', 'Dystopie');
CREATE UNIQUE INDEX idx_book_isbn ON book(isbn_number); /* Create unique index on ISBN-Number for better performance */


-- DISPLAY DATA
SELECT * FROM book;