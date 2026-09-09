#include <stdio.h>

typedef unsigned int uint;

#define SZ(arr) (sizeof(arr) / sizeof(arr[0]))
#define PRINT_SZ(arr) printf("size of '%s': %zu\n", #arr, SZ(arr));
#define FOR(i, n) for (uint i = 0; i < (n); ++i)

#pragma GCC diagnostic push
#pragma GCC diagnostic ignored "-Wunused-variable"
#pragma GCC diagnostic ignored "-Wunused-parameter"

#pragma GCC diagnostic ignored "-Wsizeof-array-argument"

void param_1d_array_NOT(int arr[5]) {
    // not possible, it decays to a pointer
    PRINT_SZ(arr)
}

void param_1d_array(int arr[5], uint size) {
    // int arr[5] same as int[] same as int *arr
    FOR(i, size) printf("%d ", arr[i]);
    printf("\n");
}

// NOT: int arr[][]
void param_2d_array(int arr[][3], uint rows, uint cols) {
    FOR(i, rows) FOR(j, cols) printf("%d ", arr[i][j]);
    printf("\n");
}

void param_2d_array2(int* arr, uint rows, uint cols) {
    FOR(i, rows) FOR(j, cols) printf("%d ", arr[i * cols + j]);
    printf("\n");
}

void param_3d_array(int arr[][3][4], uint tables, uint rows, uint cols) {
    FOR(i, tables) FOR(j, rows) FOR(k, cols) printf("%d ", arr[i][j][k]);
    printf("\n");
}

void param_all(int* arr, uint tables, uint rows, uint cols) {
    // 1D
    FOR(i, tables * rows * cols) printf("%d ", arr[i]);
    printf("\n");
    // 2D
    FOR(i, tables * rows) FOR(j, cols) printf("%d ", arr[i * cols + j]);
    printf("\n");
    // 3D
    FOR(i, tables) FOR(j, rows) FOR(k, cols) printf("%d ", arr[i * rows * cols + j * cols + k]);
    printf("\n");
}

int main() {
    int arr1d[5] = {1, 2, 3, 4, 5};
    int arr2d[5][3] = {
        {1, 2, 3}, {4, 5, 6}, {7, 8, 9}, {10, 11, 12}, {13, 14, 15}};
    int arr3d[2][3][4] = {
        {{1, 2, 3, 4}, {5, 6, 7, 8}, {9, 10, 11, 12}},
        {{13, 14, 15, 16}, {17, 18, 19, 20}, {21, 22, 23, 24}}};

    // PRINT_SZ(arr1d)
    // param_1d_array_NOT(arr1d);

    // param_1d_array(arr1d, SZ(arr1d));

    // param_2d_array(arr2d, 5, 3);
    // param_2d_array2((int*) arr2d, 5, 3);

    // param_3d_array(arr3d, 2, 3, 4);

    // param_all((int*) arr3d, 2, 3, 4);

    return 0;
}

#pragma GCC diagnostic pop
