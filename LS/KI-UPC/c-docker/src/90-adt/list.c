#include "list.h"

#include <assert.h>
#include <stdlib.h>

List* list_create() {
    // Instead of:
    //
    // List* list = (List*) malloc(sizeof(List));
    // list->head = NULL;
    // return list;
    //
    // we can write more compactly:
    return calloc(1, sizeof(List));
}

void list_destroy(List* list) {
    assert(list);

    ListNode* node = list->head;
    while (node /*!= NULL*/) {
        ListNode* temp = node;
        node = node->next;
        free(temp);
    }

    free(list);
}

static ListNode* new_node(Val val) {
    ListNode* node = calloc(1, sizeof(ListNode));
    node->val = val;
    return node;
}

void list_append(List* list, Val val) {
    assert(list);

    ListNode* newNode = new_node(val);

    // append to empty list
    if (!list->head /*== NULL*/) {
        list->head = newNode;
        return;
    }

    // find the tail
    ListNode* tail = list->head;
    while (tail->next) {
        tail = tail->next;
    }

    // append node
    tail->next = newNode;
}

void list_prepend(List* list, Val val) {
    assert(list);

    ListNode* newNode = new_node(val);

    // prepend node
    newNode->next = list->head;
    list->head = newNode;
}

void list_insert(ListNode* after, Val val) {
    assert(after);

    ListNode* newNode = new_node(val);
    newNode->next = after->next;
    after->next = newNode;
}

ListNode* list_find(List* list, Val val) {
    assert(list);

    // INstead of:
    // ListNode* node = list->head;
    // while (node) {
    //     if (node->val == val)
    //         return node;
    //     node = node->next;
    // }

    for (ListNode* node = list->head; node; node = node->next) {
        if (node->val == val)
            return node;
    }

    return NULL;
}

void list_delete(List* list, ListNode* node) {
    assert(list);
    assert(node);

    // delete head
    if (list->head == node) {
        list->head = node->next;
        free(node);
        return;
    }

    // search preceding node
    ListNode* prev = list->head;
    while (prev->next && prev->next != node) {
        prev = prev->next;
    }

    // node must have been found, otherwise caller is buggy
    assert(prev->next == node);

    // delete node
    prev->next = node->next;
    free(node);
}
