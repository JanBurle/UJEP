#include <stdio.h>

void while_loop_example() {
    int i = 0;
    while (i < 5) {
        printf("While loop iteration: %d\n", i);
        i++;
    }
}

void do_while_loop_example() {
    int i = 0;
    do {
        printf("Do-while loop iteration: %d\n", i);
        i++;
    } while (i < 5);
}

void for_loop_example() {
    for (int i = 0; i < 50; i++) {
        if (i % 10)
            continue; // Skip non-multiples of 10
        printf("For loop iteration: %d\n", i);
    }
}

void nested_loops_example() {
    for (int i = 1; i <= 3; i++) {
        for (int j = 1; j <= 3; j++) {
            printf("Nested loop iteration: i=%d, j=%d\n", i, j);
        }
    }
}

void infinite_loop_example() {
    while (1) {
        printf("This is an infinite loop. Press Ctrl+C to stop.\n");
    }
}

void pre_post_increment_example() {
    int i = 0;
    printf("Post-increment: %d\n", i++);
    printf("Pre-increment: %d\n", ++i);
    printf("Post-increment: %d %d %d - ha!\n", i++, i++, i++);
}

void infinite_for_loop_with_break_example() {
    int i = 0;
    for (;;) {
        printf("Infinite loop with break. Iteration: %d\n", i);
        if (5 <= i)
            break;
        i++;
    }
}

int main() {
    while_loop_example();
    do_while_loop_example();
    for_loop_example();
    nested_loops_example();
    infinite_for_loop_with_break_example();
    pre_post_increment_example();
    // infinite_loop_example(); // Uncomment to run the infinite loop example

    return 0;
}
