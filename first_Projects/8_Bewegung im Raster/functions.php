<?php
// Main application runner
function runGridApp() {
    $gridState = initializeGrid();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $gridState = processGridAction($gridState);
    }
    
    return $gridState;
}

function initializeGrid() {
    return [
        'grid' => createEmptyGrid(),
        'steps_taken' => 0,
        'movement_complete' => false
    ];
}

// Create empty 10x10 grid
function createEmptyGrid() {
    $grid = [];
    for ($r = 1; $r <= 10; $r++) {
        for ($c = 1; $c <= 10; $c++) {
            $grid[$r][$c] = '';
        }
    }
    return $grid;
}

function processGridAction($gridState) {
    if (isset($_POST['start'])) {
        return processMovement($gridState);
    } 
    return isset($_POST['reset']) ? initializeGrid() : $gridState;
}

// Process movement - move 4 steps to the right
function processMovement($gridState) {
    $grid = $gridState['grid'];
    $total_steps = 4;
    $startRow = 5;
    $startCol = 5;
    
    // Mark start position with "0"
    $grid[$startRow][$startCol] = '0';
    
    // Move steps to the right
    for ($step = 1; $step <= $total_steps; $step++) {
        $currentCol = $startCol + $step;
        if ($currentCol <= 10) {
            $grid[$startRow][$currentCol] = $step;
        }
    }
    
    return [
        'grid' => $grid,
        'steps_taken' => $total_steps,
        'movement_complete' => true
    ];
}
?>