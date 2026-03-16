#include <stdio.h>
#include <stdlib.h>

void param_swap_by_value(int a, int b) {
    int temp = a;
    a = b;
    b = temp;
}

void param_swap_by_reference(int* a, int* b) {
    int temp = *a;
    *a = *b;
    *b = temp;
}

void param_return(int nom, int denom, int* div, int* rem) {
    *div = nom / denom;
    *rem = nom % denom;
}

int main() {
    int x = 5, y = 10;
    printf("Before swap: x = %d, y = %d\n", x, y);

    param_swap_by_value(x, y);
    printf("After swap: x = %d, y = %d\n", x, y);

    param_swap_by_reference(&x, &y);
    printf("After swap: x = %d, y = %d\n", x, y);

    int d, r;
    param_return(17, 5, &d, &r); // d=3, r=2
    printf("div: %d, rem: %d\n", d, r);

    return 0;
}
