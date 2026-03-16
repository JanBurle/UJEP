#include <stdio.h>
#include <stdlib.h>
#include <string.h>

typedef char* str;

void string_declaration() {
    char s1[20];           // not initialized!!
    char s2[20] = "Hello"; // initialized, the rest is filled with '\0'
    char s3[] = "Hello";   // size is 6 (5 + '\0')
    char* s4 = "World";    // size is 6 (5 + '\0')

    printf("s1: '%s'\n", s1); // bad
    printf("s2: '%s'\n", s2);
    printf("s3: '%s'\n", s3);
    printf("s4: '%s'\n", s4);

    s1[0] = 'H'; // good, the whole string still bad
    s1[1] = 0;   // good, now s1 is "H"
    printf("s1: '%s'\n", s1);

    s2[0] = 'h'; // good, s2 is now "hello"
    printf("s2: '%s'\n", s2);

    s3[0] = 'h'; // good, s3 is now "hello
    printf("s3: '%s'\n", s3);

    // s4[0] = 'w'; // bad, undefined behavior, possibly crash (seg fault)
    // printf("s4: '%s'\n", s4);

    char* s5 = malloc(20); // allocated memory for 20 chars, uninitialized
    s5[0] = 'H';
    s5[1] = 0; // good, now s5 is "H"
    printf("s5: '%s'\n", s5);

    strcpy(s5, "Hello"); // copy string into allocated memory
    printf("s5: '%s'\n", s5);

    free(s5); // free allocated memory
}

void string_h() {
    char s1[] = "Hello, World!";
    printf("strlen(s1): %zu\n", strlen(s1));

    char s2[20];
    char s3[] = "Sentinel";
    // char s3[20] = "Sentinel"; // Ha!

    strcpy(s2, s1); // including the zero byte
    printf("s1: '%s'\n", s1);
    printf("s2: '%s'\n", s2);
    printf("s3: '%s'\n", s3);

    char long_string[] = "This is a too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too much too much too much too much  "
                         "too Much long a string";

    strcpy(s2, long_string);

    // strncpy(s2, long_string, 19);
    // s2[19] = '\0'; // ensure null termination

    printf("s2: '%s'\n", s2);
    printf("s3: '%s'\n", s3);

    printf("strcmp(s1, s2): %d\n", strcmp(s1, s2));
    printf("strcmp(s1, s3): %d\n", strcmp(s1, s3));
    printf("strcmp(s2, s3): %d\n", strcmp(s2, s3));
}

size_t my_strlen(str s) {
    str p = s;
    while (*p++)
        ;
    return p - s - 1;
}

str my_strcpy(str dest, str src) {
    str p = dest;
    while ((*p++ = *src++))
        ;
    return dest;
}

int my_strcmp(str s1, str s2) {
    // while (*s1 && *s1 == *s2) {
    char c;
    while ((c = *s1) && c == *s2) {
        s1++;
        s2++;
    }
    return (unsigned char) *s1 - (unsigned char) *s2;
}

void string_mine() {
    str s1 = "Hello, World!";
    printf("strlen(s1): %zu\n", my_strlen(s1));

    str s2 = malloc(my_strlen(s1) + 1);

    my_strcpy(s2, s1); // including the zero byte
    printf("s1: '%s'\n", s1);
    printf("s2: '%s'\n", s2);
    printf("strcmp(s1, s2): %d\n", my_strcmp(s1, s2));

    free(s2);
}

int main() {
    string_declaration();

    // string_h();

    // string_mine();

    return 0;
}
