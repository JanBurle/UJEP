// Snake game controlled with cursor keys
#include <ncurses.h>
#include <stdlib.h>
#include <time.h>

#define MAX_LEN 512

typedef enum { UP, DOWN, LEFT, RIGHT } Dir;

typedef struct {
    int y, x;
} Pos;

typedef struct {
    Pos body[MAX_LEN];
    int len;
    Dir dir;
} Snake;

typedef struct {
    Snake snake;
    Pos food;
    int rows, cols;
    int score;
} Game;

// ── helpers ──────────────────────────────────────────────────────────────────

static void place_food(Game* g) {
    Pos p;
    int ok;
    do {
        p.y = 1 + rand() % (g->rows - 2);
        p.x = 1 + rand() % (g->cols - 2);
        ok = 1;
        for (int i = 0; i < g->snake.len; i++) {
            if (g->snake.body[i].y == p.y && g->snake.body[i].x == p.x) {
                ok = 0;
                break;
            }
        }
    } while (!ok);
    g->food = p;
}

static void init_game(Game* g) {
    getmaxyx(stdscr, g->rows, g->cols);
    g->snake.len = 3;
    g->snake.dir = RIGHT;
    for (int i = 0; i < g->snake.len; i++) {
        g->snake.body[i].y = g->rows / 2;
        g->snake.body[i].x = g->cols / 2 - i;
    }
    g->score = 0;
    place_food(g);
}

// ── drawing
// ───────────────────────────────────────────────────────────────────

static void draw(Game* g) {
    erase();
    box(stdscr, 0, 0);
    mvprintw(0, 2, " Score: %d  (q = quit) ", g->score);

    mvaddch(g->food.y, g->food.x, '*');

    for (int i = 0; i < g->snake.len; i++) {
        char c = (i == 0) ? 'O' : 'o';
        mvaddch(g->snake.body[i].y, g->snake.body[i].x, c);
    }
    refresh();
}

// ── game logic
// ────────────────────────────────────────────────────────────────

// Returns 1 on success, 0 on collision (game over)
static int step(Game* g) {
    Pos next = g->snake.body[0];
    switch (g->snake.dir) {
    case UP:
        next.y--;
        break;
    case DOWN:
        next.y++;
        break;
    case LEFT:
        next.x--;
        break;
    case RIGHT:
        next.x++;
        break;
    }

    // wall collision
    if (next.y <= 0 || next.y >= g->rows - 1 || next.x <= 0 ||
        next.x >= g->cols - 1)
        return 0;

    // self collision (skip tail – it will move away)
    for (int i = 0; i < g->snake.len - 1; i++) {
        if (g->snake.body[i].y == next.y && g->snake.body[i].x == next.x)
            return 0;
    }

    int ate = (next.y == g->food.y && next.x == g->food.x);
    int new_len = g->snake.len + (ate ? 1 : 0);
    if (new_len > MAX_LEN)
        new_len = MAX_LEN;

    // shift body backwards, insert new head
    for (int i = new_len - 1; i > 0; i--)
        g->snake.body[i] = g->snake.body[i - 1];
    g->snake.body[0] = next;
    g->snake.len = new_len;

    if (ate) {
        g->score++;
        place_food(g);
    }
    return 1;
}

static void show_game_over(Game* g) {
    int y = g->rows / 2;
    int x = g->cols / 2 - 12;
    if (x < 1)
        x = 1;
    mvprintw(y, x, "  GAME OVER!  Score: %d  ", g->score);
    mvprintw(y + 1, x, "  Press any key to exit.  ");
    refresh();
    timeout(-1);
    getch();
}

// ── entry point
// ───────────────────────────────────────────────────────────────

void hello3(void) {
    srand((unsigned) time(NULL));

    initscr();
    cbreak();
    noecho();
    keypad(stdscr, TRUE);
    curs_set(0);  // hide cursor
    timeout(250); // getch() returns ERR after 150ms → drives the game tick

    Game g;
    init_game(&g);
    draw(&g);

    for (;;) {
        int key = getch(); // ERR on timeout, key code otherwise

        if (key == 'q' || key == 'Q')
            break;

        if (key == KEY_RESIZE) {
            init_game(&g);
        }

        // change direction; disallow 180-degree reversals
        if (key == KEY_UP && g.snake.dir != DOWN)
            g.snake.dir = UP;
        if (key == KEY_DOWN && g.snake.dir != UP)
            g.snake.dir = DOWN;
        if (key == KEY_LEFT && g.snake.dir != RIGHT)
            g.snake.dir = LEFT;
        if (key == KEY_RIGHT && g.snake.dir != LEFT)
            g.snake.dir = RIGHT;

        if (!step(&g)) {
            draw(&g);
            show_game_over(&g);
            break;
        }
        draw(&g);
    }

    endwin();
}

int main(void) {
    hello3();
    return 0;
}
