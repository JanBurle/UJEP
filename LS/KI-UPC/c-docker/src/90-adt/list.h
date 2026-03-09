#pragma once

#include "common.h"

// Instead of:
//
// struct Node {
//     Val val;
//     struct ListNode* next;
// };
// typedef struct ListNode ListNode;
//
// we can write more compactly:

typedef struct ListNode {
    Val val;
    struct ListNode* next;
} ListNode;

typedef struct {
    ListNode* head;
} List;

List* list_create();
void list_destroy(List* list);

void list_append(List* list, Val val);
void list_prepend(List* list, Val val);
void list_insert(ListNode* after, Val val);

ListNode* list_find(List* list, Val val);
void list_delete(List* list, ListNode* node);
