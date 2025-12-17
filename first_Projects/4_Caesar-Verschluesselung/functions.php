<?php

// Initialize cipher
function initializeCipher() {
    return [
        'text' => $_POST['text'] ?? '',
        'shift' => $_POST['shift'] ?? 3,
        'modus' => $_POST['modus'] ?? 'encode',
        'result' => ''
    ];
}

// Process cipher actions
function processCipherAction($cipherState) {
    if (isset($_POST['process'])) {
        return processCipher($cipherState);
    } elseif (isset($_POST['reset'])) {
        return resetCipher();
    }
    return $cipherState;
}

// Process encryption/decryption
function processCipher($cipherState) {
    $text = $cipherState['text'];
    $shift = intval($cipherState['shift']);
    $modus = $cipherState['modus'];

    if ($text === '') {
        $cipherState['result'] = "Bitte geben Sie einen Text ein.";
        return $cipherState;
    }

    if ($shift < 1 || $shift > 25) {
        $cipherState['result'] = "Verschiebung muss zwischen 1 und 25 liegen.";
        return $cipherState;
    }

    $cipherState['result'] = caesar($text, $shift, $modus === 'decode');
    return $cipherState;
}

// Caesar cipher function
function caesar($text, $shift, $decode = false) {
    $alphabet = range('A', 'Z');
    $text = mb_strtoupper($text, 'UTF-8'); // for umlauts and capital letters
    $shift = $decode ? -$shift : $shift;   // when decoding backwards

    $result = '';

    for ($i = 0; $i < mb_strlen($text); $i++) {
        $char = mb_substr($text, $i, 1);

        // Only encode/decode letters A-Z
        if (preg_match('/[A-Z]/', $char)) {
            $index = array_search($char, $alphabet);
            $newIndex = ($index + $shift + 26) % 26; // Wrap-around in alphabet
            $result .= $alphabet[$newIndex];
        } else {
            $result .= $char;
        }
    }

    return $result;
}

// Reset cipher 
function resetCipher() {
    return [
        'text' => '',
        'shift' => 3,
        'modus' => 'encode',
        'result' => ''
    ];
}
?>