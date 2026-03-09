#include "funs.h"

#include <stdlib.h>

static int sum_array(const int* values, int n);

int add(int a, int b) {
    return a + b;
}

int max(int a, int b) {
    if (a > b)
        return a;
    return b;
}

void inc_by_value(int x) {
    x++;
    (void) x;
}

void inc_by_pointer(int* x) {
    if (x)
        (*x)++;
}

int factorial(int n) {
    if (n <= 1)
        return 1;
    return n * factorial(n - 1);
}

double avg_dynamic(const int* values, int n) {
    if (!values || n <= 0)
        return 0.0;

    int* copy = (int*) malloc((size_t) n * sizeof(int));
    if (!copy)
        return 0.0;

    for (int i = 0; i < n; ++i) {
        copy[i] = values[i];
    }

    int sum = sum_array(copy, n);
    free(copy);

    return (double) sum / (double) n;
}

static int sum_array(const int* values, int n) {
    int sum = 0;
    for (int i = 0; i < n; ++i) {
        sum += values[i];
    }
    return sum;
}

/* >>> */

static int file_private_state = 100;

__attribute__((unused))
static int get_file_private_state(void) {
    return file_private_state;
}

__attribute__((unused))
static void set_file_private_state(int value) {
    file_private_state = value;
}
