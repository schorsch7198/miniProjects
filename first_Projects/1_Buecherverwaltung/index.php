<?php
include 'db.php';

// Create instance - ('mysql' if MySQL is desired)
$db = new Database('pgsql');

$books = $db->getAllBooks();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bücherverwaltung</title>
</head>
<body style="text-align:center; font-family:Arial, sans-serif;">

    <h1>Bücherliste</h1>

    <?php if ($db->getError()): ?>
        <p style="color: red;"><?php echo htmlspecialchars($db->getError()); ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0" align="center">
        <tr>
            <th>Buchtitel</th>
            <th>Autor</th>
            <th>Genre</th>
            <th>ISBN</th>
            <th>Löschen</th>
        </tr>
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['author'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['genre'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['isbn_number'] ?? ''); ?></td>
                    <td>
                        <a href="?delete=<?php echo urlencode($row['isbn_number'] ?? ''); ?>" 
                            onclick="return confirm('Buch wirklich löschen?');">🗑️</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Keine Bücher gefunden.</td></tr>
        <?php endif; ?>
    </table>

    <h2>Neues Buch anlegen</h2>
    <form   method="post" 
            action="" 
            style="display:inline-block; text-align:center;">
        <label  for="title">Buchtitel:</label><br>
        <input  type="text" 
                id="title" 
                name="title" required><br><br>

        <label  for="author">Autor:</label><br>
        <input  type="text" 
                id="author" 
                name="author" required><br><br>

        <label  for="genre">Genre:</label><br>
        <input  type="text" 
                id="genre" 
                name="genre" required><br><br>

        <label  for="isbn_number">ISBN-Nummer:</label><br>
        <input  type="text" 
                id="isbn_number" 
                name="isbn_number" required><br><br>

        <input  type="submit" 
                value="Buch speichern">
    </form>

</body>
</html>

<?php
// Close connection
$db->close();
?>