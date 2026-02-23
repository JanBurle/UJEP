#include <stdio.h>
#include <stdlib.h>

int calculate_sum(int n) {
    int sum = 0;
    for (int i = 1; i <= n; i++) {
        sum += i;
    }
    return sum;
}

int main() {
    int n = 10;

    printf("Calculating sum of numbers from 1 to %d\n", n);

    int result = calculate_sum(n);

    printf("The sum is: %d\n", result);

    return 0;
}

// overflow example
