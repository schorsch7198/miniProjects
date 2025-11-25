<?php

// Initialize app
function initializeApp() {
    return [
        'number' => $_POST['number'] ?? '',
        'result' => ''
    ];
}

// Process app
function processAppAction($appState) {
    if (isset($_POST['calculate'])) {
        return processCalculation($appState);
    } elseif (isset($_POST['neu'])) {
        return resetApp();
    }
    return $appState;
}

// Process calculation
function processCalculation($appState) {
    $number = $appState['number'];

    if ($number === '') {
        $appState['result'] = "Bitte geben Sie eine Zahl ein.";
        return $appState;
    }

    if (!is_numeric($number)) {
        $appState['result'] = "Ungültige Eingabe. Bitte geben Sie eine Zahl ein.";
        return $appState;
    }

    $appState['result'] = doubleEvenDigits((int)$number);
    return $appState;
}

// Double digits at even positions (counted from right)
function doubleEvenDigits(int $x): int {
    $result = 0;
    $position = 1;
    $place = 1;

    while ($x > 0) {
        $digit = $x % 10;
        $x = intdiv($x, 10);

        if ($position % 2 == 0) {
            $digit = ($digit * 2) % 10; // Double + handle overflow
        }

        $result += $digit * $place;

        $place *= 10;
        $position++;
    }

    return $result;
}

// Reset app
function resetApp() {
    return [
        'number' => '',
        'result' => ''
    ];
}
?>