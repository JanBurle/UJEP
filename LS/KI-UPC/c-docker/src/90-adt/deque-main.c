#include "deque.h"
#include <assert.h>
#include <stdio.h>

void print_deque(Deque* dq) {
    assert(dq);

    DequeNode *node = dq->head, *prev = NULL;
    while (node) {
        printf("%d ", node->val);
        DequeNode* next = deque_next(prev, node);
        prev = node;
        node = next;
    }
    printf("\n");
}

int main() {
    Deque* dq = deque_create();

    deque_push_tail(dq, 1);
    deque_push_tail(dq, 2);
    deque_push_tail(dq, 3);
    deque_push_head(dq, 0);

    print_deque(dq);

    deque_destroy(dq);

    return 0;
}
