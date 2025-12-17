/*
	Book Management System - PostgreSQL Version (e.g. for pgAdmin)
*/

-- DATABASE: BOOK_MANAGEMENT
DROP DATABASE IF EXISTS book_management WITH (FORCE);
CREATE DATABASE book_management;

-- -- SCHEMA: LIBRARY (Note: comment out for PostgreSQL)
-- DROP SCHEMA IF EXISTS library CASCADE;
-- CREATE SCHEMA library;

-- -- USE DATABASE (Note:Comment out for MySQL)
-- USE book_management;


-- TABLE: BOOK
DROP TABLE IF EXISTS library.book CASCADE;
CREATE TABLE library.book (
  book_id SERIAL PRIMARY KEY,
  isbn_number VARCHAR(17) NOT NULL,
  title VARCHAR(250) NOT NULL,
  author VARCHAR(150) NOT NULL,
  genre VARCHAR(100)
);


-- CREATE BOOK SAMPLES
INSERT INTO library.book (isbn_number, title, author, genre) VALUES
	('978-3-608-96376-2', 'Der Herr der Ringe', 'J. R. R. Tolkien', 'Fantasy'),
	('978-3-596-90400-9', 'Die Verwandlung', 'Franz Kafka', 'Novelle'),
	('978-3-551-55741-2', 'Harry Potter und der Stein der Weisen', 'J. K. Rowling', 'Fantasy'),
	('978-3-548-23128-2', '1984', 'George Orwell', 'Dystopie');
CREATE UNIQUE INDEX idx_book_isbn ON library.book(isbn_number); /* Create unique index on ISBN-Number for better performance */


-- DISPLAY DATA
SELECT * FROM library.book;