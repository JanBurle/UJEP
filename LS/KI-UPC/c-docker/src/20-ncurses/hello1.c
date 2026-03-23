// apt install libncurses-dev
#include <ncurses.h>
#include <string.h>

typedef unsigned int uint;

#define FOR(i, n) for (uint i = 0; i < (n); ++i)

#define SZ(arr) (sizeof(arr) / sizeof(arr[0]))
#define FOR_SZ(i, arr) FOR(i, SZ(arr))

void hello() {
    initscr(); // initialize ncurses mode

    int rows, cols;
    getmaxyx(stdscr, rows, cols); // get terminal size

    char message[] = "Hello, World!";

    // center the message
    int x = (cols - (int) strlen(message)) / 2;
    int y = rows / 2;

    mvprintw(y, x, "Hello, World!");

    refresh(); // update the screen

    getch(); // wait for a key press

    endwin(); // restore terminal
}

int main() {
    hello();
    return 0;
}
