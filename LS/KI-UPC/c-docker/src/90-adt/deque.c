#include "deque.h"

#include <assert.h>
#include <stdlib.h>

typedef uintptr_t xnp_t;

// Helper to XOR two pointers
static inline xnp_t XOR(xnp_t a, xnp_t b) {
    return a ^ b;
}

Deque* deque_create() {
    return calloc(1, sizeof(Deque));
}

void deque_destroy(Deque* dq) {
    assert(dq);

    DequeNode *node = dq->head, *prev = NULL, *next;

    while (node) {
        next = (DequeNode*) XOR((xnp_t) prev, node->xnp);
        prev = node;
        free(node);
        node = next;
    }

    free(dq);
}

bool deque_is_empty(Deque* dq) {
    assert(dq);
    return !dq->head; // return NULL == dq->head;
}

Val deque_head(Deque* dq) {
    assert(dq);
    assert(!deque_is_empty(dq));
    return dq->head->val;
}

Val deque_tail(Deque* dq) {
    assert(dq);
    assert(!deque_is_empty(dq));
    return dq->tail->val;
}

DequeNode* deque_next(DequeNode* prev, DequeNode* node) {
    assert(node);
    return (DequeNode*) XOR((xnp_t) prev, node->xnp);
}

static DequeNode* new_node(Val val) {
    DequeNode* node = calloc(1, sizeof(DequeNode));
    node->val = val;
    return node;
}

void deque_push_head(Deque* dq, Val val) {
    assert(dq);

    DequeNode* newNode = new_node(val);

    if (dq->head) {
        newNode->xnp = (uintptr_t) dq->head;
        dq->head->xnp = XOR((xnp_t) newNode, dq->head->xnp);
    } else {
        dq->tail = newNode;
    }

    dq->head = newNode;
}

void deque_push_tail(Deque* dq, Val val) {
    assert(dq);

    DequeNode* newNode = new_node(val);

    if (dq->tail) {
        newNode->xnp = (xnp_t) dq->tail;
        dq->tail->xnp = XOR(dq->tail->xnp, (xnp_t) newNode);
    } else {
        dq->head = newNode;
    }

    dq->tail = newNode;
}

Val deque_pop_head(Deque* dq) {
    assert(dq);
    assert(!deque_is_empty(dq));

    DequeNode* oldHead = dq->head;
    Val val = oldHead->val;

    DequeNode* next = (DequeNode*) oldHead->xnp;

    if (next) {
        next->xnp = XOR((xnp_t) oldHead, next->xnp);
        dq->head = next;
    } else {
        dq->head = dq->tail = NULL;
    }

    free(oldHead);
    return val;
}

Val deque_pop_tail(Deque* dq) {
    assert(dq);
    assert(!deque_is_empty(dq));

    DequeNode* oldTail = dq->tail;
    Val val = oldTail->val;

    DequeNode* prev = (DequeNode*) oldTail->xnp;

    if (prev) {
        prev->xnp = XOR(prev->xnp, (xnp_t) oldTail);
        dq->tail = prev;
    } else {
        dq->head = dq->tail = NULL;
    }

    free(oldTail);
    return val;
}
