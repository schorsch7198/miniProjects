#include <stdio.h>

#define DIAL_SIZE 100
#define START_POSITION 50

/* Count zero if dial points at 0 (IMPORTANT: counts everytime when passed 0) */
void count_zero(int pos, int *zeros)
{
    if (pos == 0)
    {
        (*zeros)++;
    }
}

/* Rotate dial and return new position */
int rotate_dial(int pos, char dir, int dis, int *zeros)
{
    for (int i = 0; i < dis; i++)
    {
        if (dir == 'R')
        {
            pos = (pos + 1) % DIAL_SIZE;
        }
        else if (dir == 'L')
        {
            pos = (pos - 1 + DIAL_SIZE) % DIAL_SIZE;
        }

        /* Count during movement */
        count_zero(pos, zeros);
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

    printf("\nCIRCULAR DIAL SAFE OPENER WITH PASS-THROUGH COUNTER\n");
    printf("Enter rotations (e.g. L1 or R23456), one per line.\n");
    printf("Press ENTER on empty line to finish.\n\n");

    while (fgets(line, sizeof(line), stdin) != NULL)
    {
        if (sscanf(line, " %c%d", &dir, &dis) == 2)
        {
            pos = rotate_dial(pos, dir, dis, &zeros);
        }
        if (line[0] == '\n') // Break on empty line
        {
            break;
        }
    }

    printf("\nFinal Dial Position: %d\n", pos);
    printf("Number of times pointing at 0 (Password): %d\n\n", zeros);

    return 0;
}
