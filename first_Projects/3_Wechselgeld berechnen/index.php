<?php
include 'functions.php';

// Initialize calculator state
$calculatorState = initializeCalculator();

// Process form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $calculatorState = processCalculatorAction($calculatorState);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Restgeldrechner</title>
</head>
<body>
    <div style="text-align:center; margin-top:50px;">
        <h1>Restgeldrechner</h1>

        <form method="post">
            <table align="center">
                <tr>
                    <td>Preis:</td>
                    <td><input  type="text" 
                                name="price" 
                                value="<?php echo htmlspecialchars($calculatorState['price']); ?>"></td>
                </tr>
                <tr>
                    <td>Gegeben:</td>
                    <td><input  type="text" 
                                name="given" 
                                value="<?php echo htmlspecialchars($calculatorState['given']); ?>"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center; padding-top:10px;">
                        <button type="submit" 
                                name="calculate">Restgeld berechnen</button>
                        <button type="submit" 
                                name="new">Neu</button>
                    </td>
                </tr>
            </table>
        </form>

        <div style="margin-top:20px; font-weight:bold;">
            <?php echo $calculatorState['result']; ?>
        </div>
    </div>
</body>
</html>