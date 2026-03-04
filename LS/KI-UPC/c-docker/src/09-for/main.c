#include <stdio.h>
#include <stdlib.h>
#include <string.h>

typedef char* str;
typedef char const* cstr;

void str_by_char1(cstr s) {
    for (int i = 0; s[i] != '\0'; ++i) {
        printf("Character at index %d: %c\n", i, s[i]);
    }
}

void str_by_char2(cstr s) {
    for (cstr p = s; *p; ++p) {
        printf("Character: %c\n", *p);
    }
}

void find_char(char c, cstr s) {
    cstr p;

    for (/*cstr*/ p = s; *p && c != *p; ++p)
        ;

    if (*p) {
        printf("Found character '%c' at position %ld\n", c, p - s);
    } else {
        printf("Character '%c' not found in the string.\n", c);
    }
}

int main() {
    cstr s = "hello, World!";
    // s[0] = 'H';
    // ((str) s)[0] = 'H'; // Phooey! Don't do this!

    // {
    //     // c11
    //     str s_copy = malloc(strlen(s) + 1);
    //     strcpy(s_copy, s);
    //     s_copy[0] = 'H';
    //     s = s_copy; // Now we can modify s safely
    //     ((str) s)[0] = 'H';
    // }

    {
        // gnu11
        str s_copy = strdup(s);
        s_copy[0] = 'H';
        s = s_copy; // Now we can modify s safely
        ((str) s)[0] = 'H';
    }

    str_by_char1(s);
    str_by_char2(s);
    find_char('o', s);
    find_char('z', s);

    free((str) s); // Clean up the duplicated string
    // free((str) s); // Clean up the duplicated string
    return 0;
}
