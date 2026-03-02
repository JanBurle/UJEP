#include <stdio.h>

#include <limits.h>
/* see: /usr/include/limits.h */

int const MAXINT = (2147483647);

void if_example() {
    if (INT_MAX == MAXINT) {
        printf("MAXINT is correct\n");
    } else {
        printf("MAXINT is incorrect\n");
    }

    if (INT_MAX == MAXINT)
        printf("MAXINT is correct\n");
    else
        printf("MAXINT is incorrect\n");

    printf("MAXINT is %scorrect\n", (INT_MAX == MAXINT) ? "" : "in");
    printf("MAXINT %s correct\n", (INT_MAX == MAXINT) ? "is" : "is not");

    int n = -42;
    // int n = INT_MAX + 1;
    if (n > 0) {
        printf("n is positive\n");
    } else if (n < 0) {
        printf("n is negative\n");
    } else {
        printf("n is zero\n");
    }
}

void switch_example(int n) {
    switch (n) {
    case 1:
        printf("n is one\n");
        break;
    case 2:
        printf("n is two\n");
        break;
    case 3:
        printf("n is three\n");
        // fall through
    case 4:
        printf("n is three or four\n");
        break;
    default:
        printf("n is something else\n");
    }
}

int main() {
    if_example();
    switch_example(1);
    switch_example(2);
    switch_example(3);
    switch_example(5);
    return 0;
}
