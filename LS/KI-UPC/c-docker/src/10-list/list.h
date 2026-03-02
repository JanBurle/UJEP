#pragma once

typedef int Val;

struct Node {
    Val val;
    struct Node* next;
};

typedef struct Node Node;

// typedef struct Node {
//     Val val;
//     struct Node* next;
// } Node;

typedef struct {
    Node* head;
} List;

List* list_create();
void list_destroy(List* list);

void list_append(List* list, Val val);
void list_prepend(List* list, Val val);
void list_insert(Node* after, Val val);

Node* list_find(List* list, Val val);
void list_delete(List* list, Node* node);
