<?php
include 'functions.php';

// Initialize calculator state
$calcState = initCalc();

// Process form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $calcState = processCalcAction($calcState);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Taschenrechner</title>
    <link   rel="stylesheet" 
            href="style.css">
</head>
<body>
    <div class="rechner">
        <form method="post">
            <input  type="text" 
                    name="display" 
                    value="<?php echo htmlspecialchars($calcState['display']); ?>" 
                    readonly class="display">

            <div class="tastenfeld">
                <!-- 1st row of buttons -->
                <button type="submit" 
                        name="button" 
                        value="7">7</button>
                <button type="submit" 
                        name="button" 
                        value="8">8</button>
                <button type="submit" 
                        name="button" 
                        value="9">9</button>
                <button type="submit" 
                        name="button" 
                        value="/">/</button>

                <!-- 2nd row -->
                <button type="submit" 
                        name="button" 
                        value="4">4</button>
                <button type="submit" 
                        name="button" 
                        value="5">5</button>
                <button type="submit" 
                        name="button" 
                        value="6">6</button>
                <button type="submit" 
                        name="button" 
                        value="*">*</button>

                <!-- 3rd row -->
                <button type="submit" 
                        name="button" 
                        value="1">1</button>
                <button type="submit" 
                        name="button" 
                        value="2">2</button>
                <button type="submit" 
                        name="button" 
                        value="3">3</button>
                <button type="submit" 
                        name="button" 
                        value="-">-</button>

                <!-- 4th row -->
                <button type="submit" 
                        name="button" 
                        value="0">0</button>
                <button type="submit" 
                        name="button" 
                        value=",">,</button>
                <button type="submit" 
                        name="button" 
                        value="C">C</button>
                <button type="submit" 
                        name="button" 
                        value="+">+</button>

                <!-- Equal button -->
                <button type="submit" 
                        name="button" 
                        value="=" 
                        class="gleich">=</button>
            </div>
        </form>
    </div>
</body>
</html>