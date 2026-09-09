#include "dlist.h"
#include <assert.h>
#include <stdio.h>

void print_list(DList* list) {
    assert(list);

    DListNode* node = list->head;
    while (node) {
        printf("%d ", node->val);
        node = node->next;
    }
    printf("\n");
}

int main() {
    DList* list = dlist_create();

    dlist_append(list, 1);
    dlist_append(list, 2);
    dlist_append(list, 3);
    dlist_prepend(list, 0);

    dlist_insert(list->head, 10);
    print_list(list);

    dlist_destroy(list);

    return 0;
}
