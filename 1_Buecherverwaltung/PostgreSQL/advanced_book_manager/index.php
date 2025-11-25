<?php
include 'functions.php';

$conn = getDBConnection();

// Handle book deletion
if (isset($_GET['delete'])) {
    if (deleteBook($conn, $_GET['delete'])) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Fehler beim Löschen des Buches: " . pg_last_error($conn) . "');</script>";
    }
}

// Handle new book addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (addBook($conn, $_POST["title"], $_POST["author"], $_POST["genre"], $_POST["isbn_number"])) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Fehler beim Hinzufügen des Buches: " . pg_last_error($conn) . "');</script>";
    }
}

$books = getAllBooks($conn);
$bookCount = getBookCount($conn);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bücherverwaltung - Modern</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1><i class="fas fa-book-open"></i> Bücherverwaltung</h1>
            <p>Verwalten Sie Ihre Büchersammlung einfach und effizient</p>
        </header>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number"><?php echo $bookCount; ?></div>
                <div class="stat-label">Bücher insgesamt</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">4</div>
                <div class="stat-label">Genres</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $bookCount; ?></div>
                <div class="stat-label">Autoren</div>
            </div>
        </div>

        <div class="card">
            <h2 class="card-title"><i class="fas fa-list"></i> Bücherliste</h2>
            
            <div class="table-container">
                <?php if ($books && pg_num_rows($books) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Titel</th>
                                <th>Autor</th>
                                <th>Genre</th>
                                <th>ISBN</th>
                                <th>Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = pg_fetch_assoc($books)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row["title"]) ?></td>
                                    <td><?= htmlspecialchars($row["author"]) ?></td>
                                    <td>
                                        <span style="background: #e9ecef; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem;">
                                            <?= htmlspecialchars($row["genre"]) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($row["isbn_number"]) ?></td>
                                    <td class="action-cell">
                                        <a href="?delete=<?= urlencode($row["isbn_number"]) ?>" 
                                           onclick="return confirm('Buch wirklich löschen?');" 
                                           class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Löschen
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-book"></i>
                        <h3>Keine Bücher gefunden</h3>
                        <p>Fügen Sie Ihr erstes Buch hinzu, um zu beginnen.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <h2 class="card-title"><i class="fas fa-plus-circle"></i> Neues Buch hinzufügen</h2>
            
            <form method="post" action="">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title"><i class="fas fa-heading"></i> Buchtitel</label>
                        <input type="text" id="title" name="title" placeholder="Geben Sie den Buchtitel ein" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="author"><i class="fas fa-user-edit"></i> Autor</label>
                        <input type="text" id="author" name="author" placeholder="Name des Autors" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="genre"><i class="fas fa-tags"></i> Genre</label>
                        <input type="text" id="genre" name="genre" placeholder="z.B. Fantasy, Krimi, Roman" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="isbn_number"><i class="fas fa-barcode"></i> ISBN-Nummer</label>
                        <input type="text" id="isbn_number" name="isbn_number" placeholder="ISBN-13 Format" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save"></i> Buch speichern
                </button>
            </form>
        </div>
    </div>

    <script>
        // Simple animation for form submission
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Wird gespeichert...';
            submitBtn.disabled = true;
        });

        // Add some interactivity to table rows
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('a')) {
                    this.style.backgroundColor = '#f0f5ff';
                    setTimeout(() => {
                        this.style.backgroundColor = '';
                    }, 300);
                }
            });
        });
    </script>
</body>
</html>
<?php
// Close connection
if ($books) {
    pg_free_result($books);
}
if ($conn) {
    pg_close($conn);
}
?>