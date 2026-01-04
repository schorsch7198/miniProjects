#include <stdio.h>
#include <string.h>

/* Check if character is a digit */
int is_digit(char c)
{
    return (c >= '0' && c <= '9');
}

/* Convert single digit char to int */
int char_to_int(char c)
{
    return c - '0';
}

/* Calculate value from two digits */
int calculate_pair_value(int tens, int units)
{
    return tens * 10 + units;
}

/* Compare and update maximum */
int update_max(int current_max, int new_value)
{
    return (new_value > current_max) ? new_value : current_max;
}

/* Process a single pair of digits */
int process_digit_pair(char digit1, char digit2, int current_max)
{
    int tens = char_to_int(digit1);
    int units = char_to_int(digit2);
    int pair_value = calculate_pair_value(tens, units);
    return update_max(current_max, pair_value);
}

/* Process inner loop for one digit position */
int process_inner_loop(char *line, int len, int i, int current_max)
{
    int max_for_position = current_max;
    
    for (int j = i + 1; j < len; j++)
    {
        if (!is_digit(line[j]))
            continue;

        max_for_position = process_digit_pair(line[i], line[j], max_for_position);
    }
    return max_for_position;
}

/* Clean the input line */
int clean_input_line(char *line)
{
    int len = strlen(line);
    
    if (len > 0 && line[len - 1] == '\n')
    {
        line[len - 1] = '\0';
        len--;
    }
    
    return len;
}

/* Main processing function */
int max_joltage_from_line(char *line)
{
    int max = 0;
    int len = clean_input_line(line);

    for (int i = 0; i < len; i++)
    {
        if (!is_digit(line[i]))
            continue;

        max = process_inner_loop(line, len, i, max);
    }

    return max;
}

int main(void)
{
    char line[4096];
    long long total = 0;

    printf("Paste battery banks (one per line).\n");
    printf("Press ENTER on empty line to finish.\n\n");

    while (1)
    {
        if (!fgets(line, sizeof(line), stdin))
            break;

        if (line[0] == '\n')
            break;

        total += max_joltage_from_line(line);
    }

    printf("\nTotal output joltage: %lld\n", total);
    return 0;
}