<?php
include 'functions.php';

// Initialize application state
$appState = initializeApp();

// Process form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appState = processAppAction($appState);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Doppelte gerade Ziffern</title>
</head>
<body>
    <div style="text-align:center; margin-top:50px;">
        <h1>Ziffern an geraden Stellen verdoppeln</h1>

        <form method="post">
            <table align="center">
                <tr>
                    <td>Zahl eingeben:</td>
                    <td><input  type="number" 
                                name="number" 
                                value="<?php echo htmlspecialchars($appState['number']); ?>"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center; padding-top:10px;">
                        <button type="submit" 
                                name="calculate">Berechnen</button>
                        <button type="submit" 
                                name="neu">Neu</button>
                    </td>
                </tr>
            </table>
        </form>

        <?php if ($appState['result'] !== ''): ?>
            <div style="margin-top:20px; font-weight:bold;">
                Ergebnis: <?php echo htmlspecialchars($appState['result']); ?>
            </div>
        <?php endif; ?>

        <div style="margin-top:30px; text-align:left; display:inline-block;">
            <h3>🧩 Testfälle</h3>
            <ul>
                <li>Input: 1234 → Output: 2264</li>
                <li>Input: 7654321 → Output: 7258341</li>
                <li>Input: 9999 → Output: 8989</li>
                <li>Input: 123456 → Output: 226406</li>
            </ul>
        </div>
    </div>
</body>
</html>