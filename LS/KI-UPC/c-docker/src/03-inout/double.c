#include "io.h"

int main() {
    int c; // int, not char

    while (EOF != (c = inp())) {
        out(c);
        out(c);
    }

    return 0;
}
