<?php include 'functions.php'; ?>
<?php $gridState = runGridApp(); ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Gitterbewegung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gitter 10x10</h1>
        <form method="post">
            <?php if (!$gridState['movement_complete']): ?>
                <button type="submit" name="start">Start (4 Schritte nach rechts)</button>
            <?php endif; ?>
            <button type="submit" name="reset">Zurücksetzen</button>
        </form>

        <div class="grid">
            <?php for ($r = 1; $r <= 10; $r++): ?>
                <?php for ($c = 1; $c <= 10; $c++): 
                    $class = '';
                    $value = $gridState['grid'][$r][$c];
                    
                    // Start position (5,5) is always red
                    if ($r == 5 && $c == 5) {
                        $class = 'start';
                    }
                    // Steps taken are red
                    elseif ($value !== '') {
                        $class = 'step';
                    }
                ?>
                    <div class="cell <?php echo $class; ?>">
                        <?php echo htmlspecialchars($value); ?>
                    </div>
                <?php endfor; ?>
            <?php endfor; ?>
        </div>
        
        <div class="info">
            <?php if ($gridState['movement_complete']): ?>
                <p>✅ Bewegung abgeschlossen! 4 Schritte nach rechts ausgeführt.</p>
            <?php else: ?>
                <p>Klicken Sie auf "Start" um 4 Schritte nach rechts zu gehen.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>