<?php
// Grid movement engine

// Initialize grid state
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

// Process grid actions
function processGridAction($gridState) {
    if (isset($_POST['start'])) {
        return processStart($gridState);
    } elseif (isset($_POST['reset'])) {
        return resetGrid();
    }
    return $gridState;
}

// Process start movement - move 4 steps to the right
function processStart($gridState) {
    $grid = $gridState['grid'];
    
    // Grid dimensions
    $rows = 10;
    $cols = 10;
    
    // Start position
    $startRow = 5;
    $startCol = 5;
    
    // Total steps to take
    $total_steps = 4;
    
    // Mark start position with "0"
    $grid[$startRow][$startCol] = '0';
    
    // Move 4 steps to the right
    for ($step = 1; $step <= $total_steps; $step++) {
        $currentCol = $startCol + $step;
        if ($currentCol <= $cols) {
            $grid[$startRow][$currentCol] = $step;
        }
    }
    
    return [
        'grid' => $grid,
        'steps_taken' => $total_steps,
        'movement_complete' => true
    ];
}

// Reset grid to initial state
function resetGrid() {
    return [
        'grid' => createEmptyGrid(),
        'steps_taken' => 0,
        'movement_complete' => false
    ];
}
?>