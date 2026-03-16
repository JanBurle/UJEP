#include <stdio.h>
#include <stdlib.h>
#include <string.h>

typedef char* str;

void array_declaration() {
    int ints[10];    // array of 10 integers
    double reals[5]; // array of 5 doubles
    char chars[20];  // array of 20 characters
    str names[3];    // array of 3 strings (pointers to char)
    int empty[0];    // not standard in C, some compilers allow it
    // int naught[];    // error, size must be specified

    size_t bytes_of_ints = sizeof(ints);
    size_t bytes_of_reals = sizeof(reals);
    size_t bytes_of_chars = sizeof(chars);
    size_t bytes_of_names = sizeof(names);
    size_t bytes_of_empty = sizeof(empty);

    size_t size_of_ints = sizeof(ints) / sizeof(ints[0]); // sizeof(int)
    size_t size_of_reals = sizeof(reals) / sizeof(reals[0]);
    size_t size_of_chars = sizeof(chars) / sizeof(chars[0]);
    size_t size_of_names = sizeof(names) / sizeof(names[0]);
    size_t size_of_empty = sizeof(empty) / sizeof(empty[0]);

    printf("ints: %lu/%lu\n", size_of_ints, bytes_of_ints);
    printf("reals: %lu/%lu\n", size_of_reals, bytes_of_reals);
    printf("chars: %lu/%lu\n", size_of_chars, bytes_of_chars);
    printf("names: %lu/%lu\n", size_of_names, bytes_of_names);
    printf("empty: %lu/%lu\n", size_of_empty, bytes_of_empty);

    // array is the same as pointer to first element
    printf("ints = %p, &ints[0] = %p\n", (void*) ints, (void*) &ints[0]);
}

void print_int_array(str name, int* arr /*int arr[]*/, size_t size) {
    // printf("/// %lu ///\n", SZ(arr)); // size of pointer, not array!
    printf("%s[%lu]: ", name, size);

    for (size_t i = 0; i < size; ++i) {
        printf("%d ", arr[i]);
    }
    printf("\n");
}

#define SZ(arr) (sizeof(arr) / sizeof(arr[0]))
#define PRINT_INT_ARRAY(arr) print_int_array(#arr, arr, SZ(arr))

#define PRINT_CHAR_ARRAY(arr) printf("%s[%lu]: %s\n", #arr, SZ(arr), arr)

void array_garbage() {
    int a[200];

    // random numbers between 0 and 99
    for (size_t i = 0; i < SZ(a); ++i) {
        a[i] = rand() % 100;
    }

    (void) a;
}

void array_initialization() {
    // uninitialized array (contains garbage)
    int a0[5];
    PRINT_INT_ARRAY(a0);

    // fully initialized array
    int a1[5] = {1, 2, 3, 4, 5};
    PRINT_INT_ARRAY(a1);

    // partial initialization (rest will be set to 0)
    int a2[5] = {1, 2};
    PRINT_INT_ARRAY(a2);

    // automatic size, determined by the number of initializers
    int a3[] = {1, 2, 3, 4, 5};
    PRINT_INT_ARRAY(a3);

    // zero-initialized array
    int a4[5] = {0};
    PRINT_INT_ARRAY(a4);

    // doubles
    double reals[4] = {3.14, 2.71, 1.41, 6};
    printf("reals: ");
    for (size_t i = 0; i < SZ(reals); ++i) {
        printf("%f ", reals[i]);
    }
    printf("\n");

    // characters and strings
    char chars[6] = {'H', 'e', 'l', 'l', 'o', '\0'};
    PRINT_CHAR_ARRAY(chars);

    // pointer ~ array of characters (string literal)
    str name = "Alice"; // 8 bytes (pointer to string literal)

#pragma GCC diagnostic push
#pragma GCC diagnostic ignored "-Wsizeof-pointer-div"

    PRINT_CHAR_ARRAY(name);
    name = "Bob"; // change pointer to another string literal
    PRINT_CHAR_ARRAY(name);

#pragma GCC diagnostic pop

    str names[2] = {"Alice", "Bob"};
    printf("names[%lu]: ", SZ(names));
    for (size_t i = 0; i < SZ(names); ++i) {
        printf("%s ", names[i]);
    }
    printf("\n");
}

void array_access() {
    int a[5] = {10, 20, 30, 40, 50};

    // access using index operator
    for (size_t i = 0; i < SZ(a); ++i) {
        printf("a[%lu] = %d\n", i, a[i]);
    }

    // access using pointer arithmetic (degradation to pointer)
    int* p = a;
    for (size_t i = 0; i < SZ(a); ++i) {
        printf("*(p + %lu) = %d\n", i, *(p + i));
    }

    for (size_t i = 0; i < SZ(a); ++i) {
        printf("*(a + %lu) = %d\n", i, *(a + i));
    }

    // int b[5];
    // a = b; // error: cannot assign to array
    // b = a; // error: cannot assign to array
}

void array_access2() {
    int a[5] = {10, 20, 30, 40, 50};
    printf("%d %d %d %d\n", a[2], *(a + 2), 2 [a], *(2 + a));
}

void pointer_arithmetic() {
    int a[5] = {10, 20, 30, 40, 50};
    int* p = a;

    printf("a: %p\n", (void*) a);

    printf("p: %p %d\n", p, *p);

    p++; // move to next element
    printf("p: %p %d\n", p, *p);

    p += 2; // move two elements forward
    printf("p: %p %d\n", p, *p);

    // number of elements between two pointers
    // (must point to the same array)
    printf("#: %ld\n", p - a);

    // number of bytes between two pointers
    printf("bytes: %ld\n", (char*) p - (char*) a);
    printf("bytes: %ld\n", (void*) p - (void*) a);
    printf("bytes: %ld\n", (size_t) p - (size_t) a);

    // fooled ya
    printf("not: %ld\n", (short*) p - (short*) a);
}

void pointer_arithmetic2() {
    int a[5] = {10, 20, 30, 40, 50};

    int *end = a + SZ(a); // one past the last element

    for (int* p = a; p != end; p++) {
        printf("%d ", *p);
    }

    printf("\n");
}

void array_pointer() {
    int a[5] = {10, 20, 30, 40, 50}; // an array of 5 integers
    int (*p)[5];                     // a pointer to an array of 5 integers
    p = &a;

    // an array of 5 pointers to integers
    int* ap[5] = {&a[0], &a[1], &a[2], &a[3], &a[4]};

    for (size_t i = 0; i < 5; ++i) {
        printf("[%lu] = %p -> %d %d %d %d\n", i, ap[i], a[i], *(*p + i), *ap[i],
               **(ap + i));
    }
}

int main() {
    // array_declaration();

    // array_garbage(); // fill stack memory with random values
    // array_initialization();

    // array_access();
    // array_access2();

    // pointer_arithmetic();
    pointer_arithmetic2();

    // array_pointer();

    return 0;
}
