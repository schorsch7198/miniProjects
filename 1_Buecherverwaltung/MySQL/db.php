<?php
// MySQL database connection
function getDBConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bücherverwaltung_gst_scheme";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Delete book by ISBN number
function deleteBook($conn, $isbn) {
    $isbn_to_delete = $conn->real_escape_string($isbn);
    return $conn->query("DELETE FROM bücher WHERE `isbn-nummer` = '$isbn_to_delete'");
}

// Insert new book into database
function insertBook($conn, $buchtitel, $autor, $genre, $isbn_nummer) {
    // Escape user input to prevent SQL injection
    $buchtitel = $conn->real_escape_string($buchtitel);
    $autor = $conn->real_escape_string($autor);
    $genre = $conn->real_escape_string($genre);
    $isbn_nummer = $conn->real_escape_string($isbn_nummer);
    
    return $conn->query("INSERT INTO bücher (buchtitel, autor, genre, `isbn-nummer`) 
        VALUES ('$buchtitel', '$autor', '$genre', '$isbn_nummer')");
}

// Retrieve all books from database
function getAllBooks($conn) {
    return $conn->query("SELECT buchtitel, autor, genre, `isbn-nummer` FROM bücher");
}

// Close database connection
function closeDBConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>