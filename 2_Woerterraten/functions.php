<?php
mb_internal_encoding("UTF-8");

// Combined runner with state initialization
function runApp() {
    $appState = createAppState(
        $_POST['searched'] ?? '',
        $_POST['current'] ?? '',
        $_POST['letter'] ?? '',
        ''
    );
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $appState = processAppAction($appState);
    }
    
    return $appState;
}

// Unified state management function
function createAppState($searched = '', 
                        $current = '', 
                        $letter = '', 
                        $report = '') {
    return compact( 'searched', 
                    'current', 
                    'letter', 
                    'report');
}

// Process app actions
function processAppAction($appState) {
    if (isset($_POST['verify'])) {
        return processLetterCheck($appState);
    } 
    return isset($_POST['new']) ? createAppState() : $appState;
}

// Combined validation and letter processing
function processLetterCheck($appState) {
    extract($appState); // Creates $searched, $current, $letter, $report
    
    if (!$searched || !$letter) {
        return createAppState($searched, $current, '', "Bitte geben Sie ein Wort und einen Buchstaben ein.");
    }

    $current = $current ?: str_repeat("-", mb_strlen($searched));
    $result = checkLetterInWord($searched, $current, $letter);
    
    return createAppState($searched, $result['newCurrent'], '', getAppMessage($result));
}

// Check letter and update field
function checkLetterInWord($searched, $current, $letter) {
    $newCurrent = '';
    $found = false;
    
    for ($i = 0; $i < mb_strlen($searched); $i++) {
        $searchedLetter = mb_substr($searched, $i, 1);
        $currentLetter = mb_substr($current, $i, 1);
        
        if (mb_strtolower($searchedLetter) === mb_strtolower($letter)) {
            $newCurrent .= $searchedLetter;
            $found = true;
        } else {
            $newCurrent .= $currentLetter;
        }
    }
    
    return compact('newCurrent', 'found');
}

// Get game message
function getAppMessage($result) {
    if (mb_strpos($result['newCurrent'], "-") === false) {
        return "Glückwunsch! Das Wort ist vollständig.";
    }
    return $result['found'] ? "Richtiger Buchstabe!" : "Falscher Buchstabe!";
}
?>