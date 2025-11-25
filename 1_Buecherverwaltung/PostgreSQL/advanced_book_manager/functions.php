<?php
function getDBConnection() {
    $host = "localhost";
    $port = "5432";
    $dbname = "book_management";
    $username = "wifiUser";
    $password = "wifi";

    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$username password=$password");
    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }
    return $conn;
}

function getAllBooks($conn) {
    return pg_query($conn, "SELECT title, author, genre, isbn_number FROM library.book ORDER BY book_id");
}

function deleteBook($conn, $isbn) {
    $isbn_to_delete = pg_escape_string($conn, $isbn);
    $result = pg_query($conn, "DELETE FROM library.book WHERE isbn_number = '$isbn_to_delete'");
    return $result;
}

function addBook($conn, $title, $author, $genre, $isbn) {
    $title = pg_escape_string($conn, $title);
    $author = pg_escape_string($conn, $author);
    $genre = pg_escape_string($conn, $genre);
    $isbn_number = pg_escape_string($conn, $isbn);

    $result = pg_query($conn, "INSERT INTO library.book (title, author, genre, isbn_number) 
                  VALUES ('$title', '$author', '$genre', '$isbn_number')");
    return $result;
}

function getBookCount($conn) {
    $result = pg_query($conn, "SELECT COUNT(*) as count FROM library.book");
    $row = pg_fetch_assoc($result);
    return $row['count'];
}
?>