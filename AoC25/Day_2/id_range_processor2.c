#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define LINE_MAX 8192

/* Check if a number is invalid:
   A number is invalid if its decimal representation
   consists of a repeating pattern. Examples:
   - 111 (pattern "1" repeated 3 times)
   - 1212 (pattern "12" repeated twice)
   - 123123 (pattern "123" repeated twice) */
int is_invalid(long long n)
{
    char s[32];
    int len;

    sprintf(s, "%lld", n);
    len = strlen(s);

    /* Try all possible pattern lengths */
    for (int pat = 1; pat <= len / 2; pat++)
    {
        /* Length must be divisible by pattern length */
        if (len % pat != 0)
            continue;

        int valid = 1;

        /* Compare pattern repetitions */
        for (int i = pat; i < len; i++)
        {
            if (s[i] != s[i % pat])
            {
                valid = 0;
                break;
            }
        }

        if (valid)
            return 1;   // invalid ID
    }

    return 0;   // valid ID
}

/* Read one arbitrarily long line from stdin */
int read_line(char *line, size_t max)
{
    char buffer[256];
    line[0] = '\0';

    while (fgets(buffer, sizeof(buffer), stdin))
    {
        if (strlen(line) + strlen(buffer) >= max)
            return 0;   // too long

        strcat(line, buffer);

        if (strchr(buffer, '\n'))
            break;
    }
    return 1;
}

/* Parse ranges and compute sum of invalid IDs */
long long process_ranges(char *line)
{
    long long sum = 0;

    /* Remove newline */
    line[strcspn(line, "\n")] = '\0';

    char *token = strtok(line, ",");

    while (token)
    {
        char *dash = strchr(token, '-');
        if (!dash)
            break;

        *dash = '\0';

        long long start = strtoll(token, NULL, 10);
        long long end   = strtoll(dash + 1, NULL, 10);

        for (long long i = start; i <= end; i++)
        {
            if (is_invalid(i))
                sum += i;
        }

        token = strtok(NULL, ",");
    }

    return sum;
}

int main(void)
{
    char line[LINE_MAX];

    printf("\n\nEnter ID ranges separated by commas:\n");
    printf("(e.g. 10-15,20-25)\nPress enter when done:\n\n");

    if (!read_line(line, LINE_MAX))
    {
        fprintf(stderr, "Input line too long\n");
        return 1;
    }

    long long sum = process_ranges(line);

    printf("\nSum of invalid IDs: %lld\n", sum);
    return 0;
}