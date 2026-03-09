#include "list.h"
#include <assert.h>
#include <stdlib.h>

List* list_create() {
    List* list = (List*) malloc(sizeof(List));
    list->head = NULL;
    return list;
}

void list_destroy(List* list) {
    assert(list);

    Node* node = list->head;
    while (node /*!= NULL*/) {
        Node* temp = node;
        node = node->next;
        free(temp);
    }
    free(list);
}

static Node* new_node(Val val) {
    Node* node = (Node*) malloc(sizeof(Node));
    node->val = val;
    node->next = NULL;
    return node;
}

void list_append(List* list, Val val) {
    assert(list);

    Node* newNode = new_node(val);

    // append to empty list
    if (!list->head /*== NULL*/) {
        list->head = newNode;
        return;
    }

    // search tail
    Node* tail = list->head;
    while (tail->next) {
        tail = tail->next;
    }

    // append node
    tail->next = newNode;
}

void list_prepend(List* list, Val val) {
    assert(list);

    Node* newNode = new_node(val);
    newNode->next = list->head;

    // prepend node
    list->head = newNode;
}

void list_insert(Node* after, Val val) {
    assert(after);

    Node* newNode = new_node(val);
    newNode->next = after->next;
    after->next = newNode;
}

Node* list_find(List* list, Val val) {
    assert(list);

    Node* node = list->head;
    while (node) {
        if (node->val == val)
            return node;
        node = node->next;
    }

    // for (Node* node = list->head; node; node = node->next) {
    //     if (node->val == val)
    //         return node;
    // }

    return NULL;
}

void list_delete(List* list, Node* node) {
    assert(list);
    assert(node);

    // delete head
    if (list->head == node) {
        list->head = node->next;
        free(node);
        return;
    }

    // search preceding node
    Node* prev = list->head;
    while (prev->next && prev->next != node) {
        prev = prev->next;
    }

    // delete node
    assert(prev->next == node);
    prev->next = node->next;
    free(node);
}
