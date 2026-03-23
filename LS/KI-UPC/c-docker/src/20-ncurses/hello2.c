#include <ncurses.h>
#include <string.h>

typedef unsigned int uint;

#define FOR(i, n) for (uint i = 0; i < (n); ++i)

#define SZ(arr) (sizeof(arr) / sizeof(arr[0]))
#define FOR_SZ(i, arr) FOR(i, SZ(arr))

void print_ctr(char* msg, int row_offset) {
    int rows, cols;
    getmaxyx(stdscr, rows, cols);

    int x = (cols - (int) strlen(msg)) / 2;
    int y = rows / 2 + row_offset;

    mvprintw(y, x, "%s", msg);
}

void draw() {
    char message[] = "Hello, World!";
    erase(); // clear the screen

    print_ctr(message, 0);
    print_ctr("Press 'q' to quit.", 1);

    refresh(); // update the screen
}

void hello() {
    initscr();

    cbreak();             // disable line buffering
    noecho();             // don't echo key presses
    keypad(stdscr, TRUE); // enable special keys (like arrow keys)

    draw();

    for (;;) {
        int key = getch();

        if (key == 'q' || key == 'Q') {
            break;
        }

        if (key == KEY_RESIZE) {
            draw();
        }
    }

    endwin();
}

int main() {
    hello();
    return 0;
}
