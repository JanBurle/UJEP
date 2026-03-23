#include <stdio.h>

typedef unsigned int uint;

#define FOR(i, n) for (uint i = 0; i < (n); ++i)

#define SZ(arr) (sizeof(arr) / sizeof(arr[0]))
#define FOR_SZ(i, arr) FOR(i, SZ(arr))

#define PRINT_SZ(arr) printf("size of '%s': %zu\n", #arr, SZ(arr));

#pragma GCC diagnostic push
#pragma GCC diagnostic ignored "-Wunused-variable"
#pragma GCC diagnostic ignored "-Wunused-parameter"

void _1d_arrays() {
    int arr[5] = {1, 2, 3, 4, 5};
    PRINT_SZ(arr)

    // for (uint i = 0; i < 5; ++i)

    FOR_SZ(i, arr) printf("%d ", arr[i]);
    printf("\n");
}

void _2d_arrays() {
    int arr[5][3] = {
        {1, 2, 3}, {4, 5, 6}, {7, 8, 9}, {10, 11, 12}, {13, 14, 15}};
    PRINT_SZ(arr)
    PRINT_SZ(arr[0])

    // for (uint i = 0; i < 5; ++i)
    //   for (uint j = 0; j < 3; ++j)

    FOR_SZ(i, arr) FOR_SZ(j, arr[0]) printf("%d ", arr[i][j]);
    printf("\n");
}

void _3d_arrays() {
    int arr[2][3][4] = {{{1, 2, 3, 4}, {5, 6, 7, 8}, {9, 10, 11, 12}},
                        {{13, 14, 15, 16}, {17, 18, 19, 20}, {21, 22, 23, 24}}};

    // for (uint i = 0; i < 5; ++i)
    //   for (uint j = 0; j < 3; ++j)
    //     for (uint k = 0; k < 4; ++k)

    FOR_SZ(i, arr)
    FOR_SZ(j, arr[0]) FOR_SZ(k, arr[0][0]) printf("%d ", arr[i][j][k]);
    printf("\n");
}

int main() {
    // _1d_arrays();
    // _2d_arrays();
    // _3d_arrays();

    return 0;
}

#pragma GCC diagnostic pop
