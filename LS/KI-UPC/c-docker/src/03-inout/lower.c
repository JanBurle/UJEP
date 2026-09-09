#include "io.h"

int main() {
    int c; // int, not char

    while (EOF != (c = inp())) {
        if ('A' <= c && c <= 'Z')
            c += 'a' - 'A';

        out(c);
    }

    return 0;
}
