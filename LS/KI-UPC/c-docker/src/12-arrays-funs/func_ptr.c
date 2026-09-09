#include <stdio.h>

typedef unsigned int uint;

#define FOR(i, n) for (uint i = 0; i < (n); ++i)

#define SZ(arr) (sizeof(arr) / sizeof(arr[0]))
#define FOR_SZ(i, arr) FOR(i, SZ(arr))

int fn_nat(int x) {
    return x;
}

int fn_lin(int x) {
    return 2 * x + 1;
}

int fn_square(int x) {
    return x * x;
}

int fn_cube(int x) {
    return x * x * x;
}

typedef int (*fn_int)(int);

int main() {
    int arr[] = {1, 2, 3, 4, 5};
    fn_int fn[] = {fn_nat, fn_lin, fn_square, fn_cube};

    FOR_SZ(f, fn) {
        FOR_SZ(i, arr) {
            printf("%d ", fn[f](arr[i]));
        }
        printf("\n");
    }

    return 0;
}
