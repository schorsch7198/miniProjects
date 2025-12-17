<?php
// Initialize calculator state
function initializeCalculator() {
    return [
        'price' => $_POST['price'] ?? '',
        'given' => $_POST['given'] ?? '',
        'result' => ''
    ];
}

// Process calculator actions
function processCalculatorAction($calculatorState) {
    if (isset($_POST['calculate'])) {
        return calculateChange($calculatorState);
    } elseif (isset($_POST['new'])) {
        return resetCalculator();
    }
    return $calculatorState;
}

// Calculate the change
function calculateChange($calculatorState) {
    $price = $calculatorState['price'];
    $given = $calculatorState['given'];

    // Validate input
    if ($price === '' || $given === '') {
        $calculatorState['result'] = "Bitte geben Sie Preis und gegebenen Betrag ein. (Preis/Betrag Bsp.: 123,45)";
        return $calculatorState;
    }

    $calculatorState['result'] = calculateRest($price, $given);
    return $calculatorState;
}

// Calculate change breakdown
function calculateRest($price, $given) {
    // Bills and coins in cents, descending
    $einheiten = [
        '50 Euro' => 5000,
        '20 Euro' => 2000,
        '10 Euro' => 1000,
        '5 Euro'  => 500,
        '2 Euro'  => 200,
        '1 Euro'  => 100,
        '50 Cent' => 50,
        '20 Cent' => 20,
        '10 Cent' => 10,
        '5 Cent'  => 5,
        '2 Cent'  => 2,
        '1 Cent'  => 1,
    ];

    // Convert comma to dot for float
    $price = floatval(str_replace(',', '.', $price));
    $given = floatval(str_replace(',', '.', $given));

    $rest = round(($given - $price) * 100); // Convert to cents
    if ($rest < 0) return "Gegebenes Geld reicht nicht aus!";

    $teile = [];
    foreach ($einheiten as $name => $wert) {
        $anzahl = intdiv($rest, $wert);
        if ($anzahl > 0) {
            $teile[] = ($anzahl > 1 ? $anzahl . ' x ' : '') . $name;
            $rest -= $anzahl * $wert;
        }
    }

    return implode(' + <br>', $teile);
}

// Reset calculator
function resetCalculator() {
    return [
        'price' => '',
        'given' => '',
        'result' => ''
    ];
}
?>