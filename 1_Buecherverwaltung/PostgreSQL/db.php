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

function handleBookDeletion($conn) {
	if (isset($_GET['delete'])) {
		$isbn_to_delete = pg_escape_string($conn, $_GET['delete']);
		$result = pg_query($conn, "DELETE FROM library.book WHERE isbn_number = '$isbn_to_delete'");
		if ($result) {
			header("Location: " . $_SERVER['PHP_SELF']);
			exit();
		} else {
			echo "Error deleting book: " . pg_last_error($conn);
		}
	}
}

function handleBookInsertion($conn) {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$title = pg_escape_string($conn, $_POST["title"]);
		$author = pg_escape_string($conn, $_POST["author"]);
		$genre = pg_escape_string($conn, $_POST["genre"]);
		$isbn_number = pg_escape_string($conn, $_POST["isbn_number"]);

		$result = pg_query($conn, 
			"INSERT INTO library.book (title, author, genre, isbn_number) VALUES 
				('$title', 
				'$author', 
				'$genre', 
				'$isbn_number')");
			
		if (!$result) {
			echo "Error inserting book: " . pg_last_error($conn);
		} else {
			header("Location: " . $_SERVER['PHP_SELF']);
			exit();
		}
	}
}

function getAllBooks($conn) {
	return pg_query($conn, "SELECT title, author, genre, isbn_number FROM library.book ORDER BY book_id");
}

function closeDBConnection($conn, $result = null) {
	if ($result) {
		pg_free_result($result);
	}
	if ($conn) {
		pg_close($conn);
	}
}
?>