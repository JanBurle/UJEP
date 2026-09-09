#include "dlist.h"

#include <assert.h>
#include <stdlib.h>

DList* dlist_create() {
    return calloc(1, sizeof(DList));
}

void dlist_destroy(DList* list) {
    assert(list);

    DListNode* node = list->head;
    while (node /*!= NULL*/) {
        DListNode* temp = node;
        node = node->next;
        free(temp);
    }

    free(list);
}

static DListNode* new_node(Val val) {
    DListNode* node = calloc(1, sizeof(DListNode));
    node->val = val;
    return node;
}

void dlist_append(DList* list, Val val) {
    assert(list);

    DListNode* newNode = new_node(val);

    // append to empty list
    if (!list->tail) {
        list->head = list->tail = newNode;
        return;
    }

    // append node
    newNode->prev = list->tail;

    // Instead of:
    // list->tail->next = newNode;
    // list->tail = newNode;
    list->tail = list->tail->next = newNode;
}

void dlist_prepend(DList* list, Val val) {
    assert(list);

    // prepend to empty list
    if (!list->head) {
        return dlist_append(list, val); // reuse append
    }

    DListNode* newNode = new_node(val);

    newNode->next = list->head;
    list->head = list->head->prev = newNode;
}

void dlist_insert(DListNode* after, Val val) {
    assert(after);

    DListNode* newNode = new_node(val);
    newNode->next = after->next;
    newNode->prev = after;
    after->next = newNode;
}

void dlist_delete(DList* list, DListNode* node) {
    assert(list);
    assert(node);

    // delete head
    if (node == list->head) {
        list->head = node->next;
        if (list->head)
            list->head->prev = NULL;
        else
            list->tail = NULL;       // list becomes empty
    } else if (node == list->tail) { // delete tail
        list->tail = node->prev;
        if (list->tail)
            list->tail->next = NULL;
        else
            list->head = NULL; // list becomes empty
    } else {                   // delete middle node
        node->prev->next = node->next;
        node->next->prev = node->prev;
    }

    free(node);
}
