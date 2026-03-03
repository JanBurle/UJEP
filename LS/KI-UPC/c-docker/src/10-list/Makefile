CC = cc
CFLAGS = -std=c11 -g -Wall -Wextra

.PHONY: all run clean

all: main

run: all
	@./main

%.o: %.c %.h
	$(CC) $(CFLAGS) -c -o $@ $<

main: main.o list.o
	$(CC) $(CFLAGS) -o main $^

clean:
	rm -f lower double *.o a.out
