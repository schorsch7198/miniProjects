<?php

// Initialize calculator
function initCalc() {
    return [
        'display' => $_POST['display'] ?? "",
        'error' => false
    ];
}

// Process calculator 
function processCalcAction($calcState) {
    if (isset($_POST['button'])) {
        return processButtonPress($calcState, $_POST['button']);
    }
    return $calcState;
}

// Process button press
function processButtonPress($calcState, $button) {
    $display = $calcState['display'];
    $error = false;

    if ($button === "C") {
        $display = "";
    } elseif ($button === "=") {
        $display = evaluateExpression($display);
        if ($display === "Fehler!") {
            $error = true;
        }
    } else {
        $display .= $button;
    }

    return [
        'display' => $display,
        'error' => $error
    ];
}

// Evaluate mathematical expression
function evaluateExpression($expression) {
    // Ensure only allowed characters are present
    if (!preg_match('/^[0-9+\-*,\/]+$/', $expression)) {
        return "Fehler!";
    }

    // Replace comma with dot for eval
    $calculation = str_replace(',', '.', $expression);
    
    try {
        $result = eval("return $calculation;");
        
        // Convert dot back to comma for decimal numbers
        if (is_float($result) || strpos((string)$result, '.') !== false) {
            $result = str_replace('.', ',', $result);
        }
        
        return $result;
    } catch (\Throwable $e) {
        return "Fehler!";
    }
}
?>