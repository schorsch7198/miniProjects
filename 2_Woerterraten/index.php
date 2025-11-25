<?php 
include 'functions.php';
$appState = runApp();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Buchstaben prüfen (mit Tab-Steuerung)</title>
</head>
<body>
    <div style="text-align:center; margin-top:50px;">
        <h1>Buchstaben prüfen</h1>

        <form method="post">
            <table align="center">
                <tr>
                    <td>Gesucht (neues Wort):</td>
                    <td><input  type="text" 
                                name="searched" 
                                value="<?php echo htmlspecialchars($appState['searched']); ?>"></td>
                </tr>
                <tr>
                    <td>Aktuell:</td>
                    <td><input  type="text" 
                                name="current" 
                                value="<?php echo htmlspecialchars($appState['current']); ?>" 
                                readonly 
                                tabindex="-1"></td>
                </tr>
                <tr>
                    <td>Buchstabe:</td>
                    <td><input  type="text" 
                                name="letter" 
                                maxlength="1" 
                                value="<?php echo htmlspecialchars($appState['letter']); ?>" 
                                autofocus></td>
                </tr>
                <tr>
                    <td colspan="2" 
                        style="text-align:center; padding-top:10px;">
                        <button type="submit" 
                                name="verify">
                                    Prüfen</button>
                        <button type="submit" 
                                name="new">
                                    Neu starten</button>
                    </td>
                </tr>
            </table>
        </form>
        
        <p><?php echo htmlspecialchars($appState['report']); ?></p>
    </div>
</body>
</html>