#pragma once

#include "common.h"
#include <stdint.h>

typedef struct DequeNode {
    Val val;
    uintptr_t xnp; // XOR of prev and next
} DequeNode;

typedef struct {
    DequeNode* head;
    DequeNode* tail;
} Deque;

Deque* deque_create();
void deque_destroy(Deque* dq);

bool deque_is_empty(Deque* dq);

Val deque_head(Deque* dq);
Val deque_tail(Deque* dq);
DequeNode* deque_next(DequeNode* prev, DequeNode* node);

void deque_push_head(Deque* dq, Val val);
void deque_push_tail(Deque* dq, Val val);
Val deque_pop_head(Deque* dq);
Val deque_pop_tail(Deque* dq);
