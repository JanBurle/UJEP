#include <stdio.h>

typedef char bool; // nevertheless promoted to int
#define true 1
#define false 0

// hexadecimal print macro
#define PRINT_HEX(TAG, VAL) printf("%s = %02x\n", TAG, VAL);

// binary print macro
#define BOOL_TO_BIN(b)                                                         \
    (b & 0x80 ? '1' : '0'), (b & 0x40 ? '1' : '0'), (b & 0x20 ? '1' : '0'),    \
        (b & 0x10 ? '1' : '0'), (b & 0x08 ? '1' : '0'),                        \
        (b & 0x04 ? '1' : '0'), (b & 0x02 ? '1' : '0'), (b & 0x01 ? '1' : '0')

#define PRINT_BIN(TAG, VAL)                                                    \
    printf("%s = %c%c%c%c %c%c%c%c\n", TAG, BOOL_TO_BIN((VAL)));

/*
#define BOOL_TO_BIN(b)                                                         \
    (b & 0x80 ? 1 : 0), (b & 0x40 ? 1 : 0), (b & 0x20 ? 1 : 0),                \
        (b & 0x10 ? 1 : 0), (b & 0x08 ? 1 : 0), (b & 0x04 ? 1 : 0),            \
        (b & 0x02 ? 1 : 0), (b & 0x01 ? 1 : 0)

#define PRINT_BIN(TAG, VAL)                                                    \
    printf("%s = %d%d%d%d %d%d%d%d\n", TAG, BOOL_TO_BIN((VAL)));
*/

#define PRINT PRINT_HEX
#define PRINT PRINT_HEX
// #define PRINT PRINT_BIN

int main() {
    bool a = 3, b = 8, c = false;

    PRINT("a", a);
    PRINT("b", b);
    PRINT("c", c);
    printf("\n");

    // Logical operators: AND, OR, NOT
    PRINT("a && b", a && b);
    PRINT("a || b", a || b);
    PRINT("    !b", !b);
    PRINT("    !c", !c);
    printf("\n");

    // Bitwise operators: AND, OR, XOR, NOT, Left shift, Right shift
    PRINT("&", a & b);
    PRINT("|", a | b);
    PRINT("^", a ^ b);
    PRINT("~", ~a); // !!!!
    PRINT("~", (unsigned char) (~a));
    PRINT("<<", a << 1);
    PRINT(">>", a >> 1);

    return 0;
}
