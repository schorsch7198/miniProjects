#include <stdio.h>

#define DIAL_SIZE 100
#define START_POSITION 50

/* Count zeros if dial points at 0 (IMPORTANT: counts new positions at 0) */
int count_zero(int pos, int zeros)
{
    if (pos == 0)
    {
        zeros++;
    }
    return zeros;
}

/* Rotate dial and return new position */
int rotate_dial(int pos, char dir, int dis) // pos: position | dir: direction - 'L' or 'R' | dis: distance - steps to move
{
    if (dir == 'R')
    {
        pos = (pos + dis) % DIAL_SIZE;
    }
    else if (dir == 'L')
    {
        pos = (pos - dis) % DIAL_SIZE;
        if (pos < 0)
        {
            pos += DIAL_SIZE;
        }
    }
    return pos;
}

int main(void)
{
    int pos = START_POSITION;
    int zeros = 0;
    char dir;
    int dis;
    char line[32]; // Buffer for input lines

    printf("\nCIRCULAR DIAL SAFE OPENER WITH COUNTER (if new position is 0)\n");
    printf("Enter rotations (e.g. L1 or R23456), one per line.\n\n");

    while (fgets(line, sizeof(line), stdin) != NULL)
    {
        if (sscanf(line, " %c%d", &dir, &dis) == 2)
        {
            pos = rotate_dial(pos, dir, dis);
            zeros = count_zero(pos, zeros);
        }
        if (line[0] == '\n') // Break on empty line
        {
            break;
        }
    }

    printf("Final Dial Position: %d\n", pos);
    printf("Number of Zeros (Password): %d\n\n", zeros);
    return 0;
}

// Compiling Command: gcc dial_safe.c -o safe.exe
// Running Command: safe.exe   "or"   ./safe.exe

/*
    // 'Old' version in PHP (from Mr.Grösswang)
    $lPos   = $lPos + $lNr;
    if ($lPos == 0) 
    {
        // echo "(0)";  // 0 erreicht
        $lResult++;
    }
    else if ($lPos >= 100)    
    {
        // echo "(+)"; // positiver überlauf
        $lResult   += intdiv(abs($lPos),100);
    }
    else if ($lPos <= -100)    
    {
        // echo "(-)"; // negativer Überlauf
        $lResult   += ($lOld == 0 ? 0 : 1) + intdiv(abs($lPos),100);
    }
    else if (($lOld>0 && $lPos < 0) || ($lOld<0 && $lPos>0)    )
    {
        // echo "(x)";  // Vorzeichenwechsel (ohne 0)
        $lResult++;
    }
    $lPos       = $lPos % 100;
    if ($lPos<0) $lPos += 100;
*/