#include "io.h"

#include <stdio.h>
#ifdef NOBUFFER
#include <unistd.h>
#endif

// read from stdin
int inp() {
#ifdef NOBUFFER
    char c;
    int size = read(0, &c, 1);
    return size ? c : EOF;
#else
    return getchar();
#endif
}

// write to stdout
void out(int c) {
#ifdef NOBUFFER
    write(1, &c, 1);
#else
    putchar(c);
#endif
}
