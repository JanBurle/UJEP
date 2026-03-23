CC = cc
CFLAGS = -std=c11 -Wall -Wextra -Wstrict-prototypes

.PHONY: all run clean

all: calc

calc: calc.c
	$(CC) $(CFLAGS) -o calc $^

run: calc
	./calc

clean:
	rm -f calc *.o a.out
