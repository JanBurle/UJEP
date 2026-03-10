#include <stdio.h>

#include "funs.h"
#include "scope.h"

static void header(const char* title) {
    printf("\n=== %s ===\n", title);
}

// ends with semicolon: "function-like" macro
#define HEADER(title) header(title);

#define PRINT_1_(expr) printf("%s = %d\n", #expr, (int) expr);
#define PRINT_2_(prefix, expr)                                                 \
    printf("%s: %s = %d\n", prefix, #expr, (int) expr);

int main(void) {
    HEADER("Functions: declare, define, call")

    PRINT_1_(add(2, 3))
    PRINT_1_(max(7, 4))

    HEADER("Argument passing")

    int a = 5;
    PRINT_1_(a);

    inc_by_value(a);
    PRINT_2_("after inc_by_value(a):", a);

    inc_by_pointer(&a);
    PRINT_2_("after inc_by_pointer(&a):", a);

    HEADER("Recursion")

    for (int i = 0; i <= 5; ++i) {
        printf("factorial(%d) = %d\n", i, factorial(i));
    }

    HEADER("Dynamic variables (malloc/free)")

    int values[] = {2, 4, 6, 8};
    PRINT_1_(avg_dynamic(values, 4));

    HEADER("Scope, lifetime, extern, static")

    PRINT_2_("start", global_counter);
    set_global_counter(10);
    inc_global_counter();
    PRINT_2_("end", global_counter);

    PRINT_2_("start", get_file_private_state());
    set_file_private_state(250);
    PRINT_2_("end", get_file_private_state());

    PRINT_1_(call_count_demo());
    PRINT_1_(call_count_demo());
    PRINT_1_(call_count_demo());

    HEADER("Structs and typedefs")

    Point p1 = create_point(2, 3);
    Point p2 = create_point(4, 5);
    Point p3 = add_points(p1, p2);
    printf("p3 = (%d, %d)\n", p3.x, p3.y);

    HEADER("Out of bounds stack")
    for (int i = 2;; i *= 2) {
        printf("factorial(%d) = %d\n", i, factorial(i));
    }

    return 0;
}
