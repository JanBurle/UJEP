#include "scope.h"

int global_counter = 0;

static int file_private_state = 100;

void set_global_counter(int value) {
    global_counter = value;
}

void inc_global_counter(void) {
    global_counter++;
}

int get_file_private_state(void) {
    return file_private_state;
}

void set_file_private_state(int value) {
    file_private_state = value;
}

int call_count_demo(void) {
    static int calls = 0;
    calls++;
    return calls;
}
