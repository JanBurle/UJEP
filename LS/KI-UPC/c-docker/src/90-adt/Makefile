CC = cc
CFLAGS = -std=c11 -g -Wall -Wextra

.PHONY: all run clean

all: list-main dlist-main deque-main

%.o: %.c %.h
	$(CC) $(CFLAGS) -c -o $@ $<

list-main: list-main.o list.o
	$(CC) $(CFLAGS) -o $@ $^

dlist-main: dlist-main.o dlist.o
	$(CC) $(CFLAGS) -o $@ $^

deque-main: deque-main.o deque.o
	$(CC) $(CFLAGS) -o $@ $^

clean:
	rm -f list-main dlist-main deque-main *.o a.out
