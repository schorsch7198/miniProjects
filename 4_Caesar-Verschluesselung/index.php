<?php
include 'functions.php';

// Initialize cipher 
$cipherState = initializeCipher();

// Process form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cipherState = processCipherAction($cipherState);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Caesar-Verschlüsselung</title>
</head>
<body>
    <div style="text-align:center; margin-top:50px;">
        <h1>Caesar-Verschlüsselung</h1>

        <form method="post">
            <table align="center">
                <tr>
                    <td>Text:</td>
                    <td><input  type="text" 
                                name="text" 
                                size="40" 
                                value="<?php echo htmlspecialchars($cipherState['text']); ?>"></td>
                </tr>
                <tr>
                    <td>Verschiebung:</td>
                    <td><input  type="number" 
                                name="shift" 
                                value="<?php echo htmlspecialchars($cipherState['shift']); ?>"
                                min="1" 
                                max="25"></td>
                </tr>
                <tr>
                    <td>Modus:</td>
                    <td>
                        <label><input   type="radio" 
                                        name="modus" 
                                        value="encode" <?php echo ($cipherState['modus'] !== 'decode') 
                                        ? 'checked' 
                                        : ''; ?>> Codieren</label>
                        <label><input   type="radio" 
                                        name="modus" 
                                        value="decode" <?php echo ($cipherState['modus'] === 'decode') 
                                        ? 'checked' 
                                        : ''; ?>> Dekodieren</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center; padding-top:10px;">
                        <button type="submit" 
                                name="process">Ausführen</button>
                        <button type="submit" 
                                name="reset">Zurücksetzen</button>
                    </td>
                </tr>
            </table>
        </form>

        <?php if ($cipherState['result'] !== ''): ?>
            <div style="margin-top:20px; font-weight:bold;">
                Ergebnis:<br><?php echo htmlspecialchars($cipherState['result']); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>