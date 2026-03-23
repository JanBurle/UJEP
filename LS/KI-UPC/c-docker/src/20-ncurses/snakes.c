#include <ncurses.h>
#include <stdbool.h>
#include <stdlib.h>
#include <time.h>

typedef enum { UP, DOWN, LEFT, RIGHT } Dir;

#define MAX_LEN 512

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

// == helpers ==

static Pos rand_pos(Game* g) {
    return (Pos) {1 + rand() % (g->rows - 2), 1 + rand() % (g->cols - 2)};
}

static inline bool pos_equal(Pos a, Pos b) {
    return a.y == b.y && a.x == b.x;
}

static inline int min(int a, int b) {
    return a < b ? a : b;
}

static bool on_snake(Snake* s, Pos p) {
    Pos* body = s->body;
    int len = s->len;

    for (int i = 0; i < len; ++i) {
        if (pos_equal(p, body[i])) {
            return true;
        }
    }

    return false;
}

static void place_food(Game* g) {
    Pos p;
    do {
        p = rand_pos(g);
    } while (on_snake(&g->snake, p));
    g->food = p;
}

static void init_game(Game* g) {
    getmaxyx(stdscr, g->rows, g->cols);

    Snake* s = &g->snake;
    s->len = 3;
    s->dir = RIGHT;
    Pos* body = s->body;

    for (int i = 0; i < s->len; ++i) {
        body[i].y = g->rows / 2;
        body[i].x = g->cols / 2 - i;
    }

    g->score = 0;
    place_food(g);
}

// == drawing ==

static void draw(Game* g) {
    erase();
    box(stdscr, 0, 0);
    mvprintw(0, 2, " Score: %d  (q = quit) ", g->score);

    mvaddch(g->food.y, g->food.x, '*');

    Snake* s = &g->snake;
    Pos* body = s->body;

    for (int i = 0; i < s->len; i++) {
        char c = (i == 0) ? 'O' : 'o';
        mvaddch(body[i].y, body[i].x, c);
    }

    refresh();
}

// == game logic ==

// Returns true on success, false on collision (game over)
static bool step(Game* g) {
    Snake* s = &g->snake;
    Pos* body = s->body;
    Pos next = body[0];

    switch (s->dir) {
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
        return false;

    // self collision (skip tail – it will move away)
    for (int i = 0; i < s->len - 1; i++) {
        if (pos_equal(next, body[i]))
            return false;
    }

    int ate = pos_equal(next, g->food);
    int new_len = min(g->snake.len + ate, MAX_LEN);

    // shift body backwards, insert new head
    for (int i = new_len - 1; i > 0; i--)
        body[i] = body[i - 1];
    s->body[0] = next;
    s->len = new_len;

    if (ate) {
        g->score++;
        place_food(g);
    }
    return true;
}

static void show_game_over(Game* g) {
    int y = g->rows / 2;
    int x = g->cols / 2 - 12;
    if (x < 1)
        x = 1;

    mvprintw(y, x, "  GAME OVER!  Score: %d  ", g->score);
    mvprintw(y + 1, x, "  Press any key to exit.  ");
    refresh();

    timeout(-1); // wait for key press
    getch();
}

// == entry point ==

void game(void) {
    srand((unsigned) time(NULL));

    initscr();
    cbreak();
    noecho();
    keypad(stdscr, TRUE);
    curs_set(0);  // hide cursor
    timeout(150); // getch() returns ERR after delay (ms) → drives the game tick

    Game g;
    init_game(&g);

    draw(&g);

    Dir* dir = &g.snake.dir;

    for (;;) {
        int key = getch(); // ERR on timeout, key code otherwise

        if ('q' == key || 'Q' == key)
            break;

        if (key == KEY_RESIZE)
            init_game(&g);

        // change direction; disallow reversals
        switch (key) {
        case KEY_UP:    if (*dir != DOWN)  *dir = UP;    break;
        case KEY_DOWN:  if (*dir != UP)    *dir = DOWN;  break;
        case KEY_LEFT:  if (*dir != RIGHT) *dir = LEFT;  break;
        case KEY_RIGHT: if (*dir != LEFT)  *dir = RIGHT; break;
        }

        bool res = step(&g);
        draw(&g);
        if (!res) {
            show_game_over(&g);
            break;
        }
    }

    endwin();
}

int main(void) {
    game();
    return 0;
}
