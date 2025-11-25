<?php
include 'db.php';

$conn = getDBConnection();
// Delete book if requested
if (isset($_GET['delete'])) {
	if (deleteBook($conn, $_GET['delete'])) {
		header("Location: " . $_SERVER['PHP_SELF']);
		exit();
	}
}
// Create new book
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	insertBook($conn, 	$_POST["buchtitel"], 
						$_POST["autor"], 
						$_POST["genre"], 
						$_POST["isbn_nummer"]);
	header("Location: " . $_SERVER['PHP_SELF']);
	exit();
}
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
		<?php if ($result && $result->num_rows > 0): ?>
			<?php while ($row = $result->fetch_assoc()): ?>
				<tr>
					<td><?php echo htmlspecialchars($row["buchtitel"]); ?></td>
					<td><?php echo htmlspecialchars($row["autor"]); ?></td>
					<td><?php echo htmlspecialchars($row["genre"]); ?></td>
					<td><?php echo htmlspecialchars($row["isbn-nummer"]); ?></td>
					<td>
						<a 	href="?delete=<?php echo urlencode($row["isbn-nummer"]); ?>" 
							onclick="return confirm('Buch wirklich löschen?');">🗑️</a>
					</td>
				</tr>
			<?php endwhile; ?>
		<?php else: ?>
			<tr><td colspan="5">Keine Bücher gefunden.</td></tr>
		<?php endif; ?>
	</table>	<h2>Neues Buch anlegen</h2>
	<form 	method="post" 
			action="" 
			style="display:inline-block; text-align:center;">
		<label 	for="buchtitel">Buchtitel:</label><br>
		<input 	type="text" 
				id="buchtitel" 
				name="buchtitel" 
				required><br><br>

		<label 	for="autor">Autor:</label><br>
		<input 	type="text" 
				id="autor" 
				name="autor" 
				required><br><br>

		<label 	for="genre">Genre:</label><br>
		<input 	type="text" 
				id="genre" 
				name="genre" 
				required><br><br>

		<label 	for="isbn_nummer">ISBN-Nummer:</label><br>
		<input 	type="text" 
				id="isbn_nummer" 
				name="isbn_nummer" 
				required><br><br>
		<input 	type="submit" 
				value="Buch speichern">
	</form>
</body>
</html>


<?php
closeDBConnection($conn);
?>