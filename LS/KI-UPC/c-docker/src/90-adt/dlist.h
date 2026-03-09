#pragma once

#include "common.h"

typedef struct DListNode {
    Val val;
    struct DListNode *next, *prev; // <- Ha! Stars!
} DListNode;

typedef struct {
    DListNode* head;
    DListNode* tail;
} DList;

DList* dlist_create();
void dlist_destroy(DList* list);

void dlist_append(DList* list, Val val);
void dlist_prepend(DList* list, Val val);
void dlist_insert(DListNode* after, Val val);

DListNode* dlist_find(DList* list, Val val);
void dlist_delete(DList* list, DListNode* node);
