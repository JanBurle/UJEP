CC = cc
CFLAGS = -std=c11 -Wall -Wextra

.PHONY: all run clean

all: arrays1 arrays2

arrays1: arrays1.o
	$(CC) $(CFLAGS) -o $@ $^

arrays2: arrays2.o
	$(CC) $(CFLAGS) -o $@ $^

func_ptr: func_ptr.o
	$(CC) $(CFLAGS) -o $@ $^

%.o: %.c %.h
	$(CC) $(CFLAGS) -c -o $@ $<

run: func_ptr
	./func_ptr

clean:
	rm -f arrays1 arrays2 func_ptr *.o a.out
