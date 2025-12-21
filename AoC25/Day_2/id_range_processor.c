#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define LINE_MAX 8192

/* Check if a number is invalid:
   A number is invalid if its decimal representation
   has an even number of digits and the first half
   matches the second half. */
int is_invalid(long long n)
{
    char s[32];
    int len;

    sprintf(s, "%lld", n);
    len = strlen(s);

    /* Must have even length */
    if (len % 2 != 0)
        return 0;

    int half = len / 2;

    /* Compare first half with second half */
    for (int i = 0; i < half; i++)
    {
        if (s[i] != s[i + half])
            return 0;
    }

    return 1; // invalid
}

/* Read one arbitrarily long line from stdin */
int read_line(char *line, size_t max)
{
    char buffer[256];
    line[0] = '\0';

    while (fgets(buffer, sizeof(buffer), stdin))
    {
        if (strlen(line) + strlen(buffer) >= max)
            return 0; // too long

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
        long long end = strtoll(dash + 1, NULL, 10);

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