#include "list.h"
#include <assert.h>
#include <stdio.h>

void print_list(List* list) {
    assert(list);

    ListNode* node = list->head;
    while (node) {
        printf("%d ", node->val);
        node = node->next;
    }
    printf("\n");
}

int main() {
    List* list = list_create();

    list_append(list, 1);
    list_append(list, 2);
    list_append(list, 3);
    list_prepend(list, 0);

    list_find(list, 2)->val = 20;

    list_insert(list->head, 10);

    print_list(list);

    // valgrind
    // list_destroy(list);

    return 0;
}
