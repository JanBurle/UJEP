#include <stdio.h>

/*/
gcc - c main.c
objdump - d -M intel main.o

gcc -c - O1 main.c
objdump - d -M intel main.o
*/

/* 2's complement */
int const MAXINT = (2147483647);
// int const MAXINT = (0x7FFFFFFF);
// const int MAXINT = (2147483647);

// typedef unsigned int uint;

int main() {

    // int i = MAXINT;

    // printf("%d\n", i);
    // printf("%d\n", i + 1);

    // int i = MAXINT;

    // printf("%u\n", (unsigned int)i);
    // printf("%u\n", (unsigned int)i + 1);
    // printf("%u\n", i);
    // printf("%u\n", i + 1);

    // int i = MAXINT;
    // unsigned int ui = (unsigned int) i;
    // float f = i;

    // printf("%f\n", i);
    // printf("%f\n", (float) i);
    // printf("%f\n", f);
    // printf("%f\n", (float) (i + 1));
    // printf("%f\n", (float) (ui + 1));

    return 0;
}
