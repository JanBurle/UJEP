#include <stdio.h>

int main() {
    int c; // not char

    while (EOF != (c = getchar())) {
        putchar(c);
        putchar(c);
    }

    // while (EOF != (c = getchar())) {
    //     if ('A' <= c && c <= 'Z')
    //         c += 'a' - 'A';

    //     putchar(c);
    // }

    return 0;
}

// use read() and write() with a buffer(e.g., char buffer[4096]).
