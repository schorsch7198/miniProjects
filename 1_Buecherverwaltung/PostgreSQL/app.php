<?php
include 'db.php';

// Database connection
$conn = getDBConnection();

// Handle book operations
handleBookDeletion($conn);
handleBookInsertion($conn);

// Get all books
$result = getAllBooks($conn);
?>


<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Bücherverwaltung</title>
</head>
<body style="text-align:center; font-family:Arial, sans-serif;">

	<h1>Bücherliste</h1>

	<table border="1" cellpadding="8" cellspacing="0" align="center">
		<tr>
			<th>Buchtitel</th>
			<th>Autor</th>
			<th>Genre</th>
			<th>ISBN</th>
			<th>Löschen</th>
		</tr>
		<?php if ($result && pg_num_rows($result) > 0): ?>
			<?php while ($row = pg_fetch_assoc($result)): ?>
				<tr>
					<td><?php echo htmlspecialchars($row["title"]); ?></td>
					<td><?php echo htmlspecialchars($row["author"]); ?></td>
					<td><?php echo htmlspecialchars($row["genre"]); ?></td>
					<td><?php echo htmlspecialchars($row["isbn_number"]); ?></td>
					<td>
						<a href="?delete=<?php echo urlencode($row["isbn_number"]); ?>" 
							onclick="return confirm('Buch wirklich löschen?');">🗑️</a>
					</td>
				</tr>
			<?php endwhile; ?>
		<?php else: ?>
			<tr><td colspan="5">Keine Bücher gefunden.</td></tr>
		<?php endif; ?>
	</table>

	<h2>Neues Buch anlegen</h2>
	<form method="post" action="" style="display:inline-block; text-align:center;">
		<label for="title">Buchtitel:</label><br>
		<input type="text" id="title" name="title" required><br><br>

		<label for="author">Autor:</label><br>
		<input type="text" id="author" name="author" required><br><br>

		<label for="genre">Genre:</label><br>
		<input type="text" id="genre" name="genre" required><br><br>

		<label for="isbn_number">ISBN-Nummer:</label><br>
		<input type="text" id="isbn_number" name="isbn_number" required><br><br>

		<input type="submit" value="Buch speichern">
	</form>

</body>
</html>

<?php
// Close connection
closeDBConnection($conn, $result);
?>