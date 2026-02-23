CC = cc
CFLAGS = -std=c11 -Wall -Wextra

.PHONY: all clean

all: main

main: main.c
	$(CC) $(CFLAGS) -o main $^

clean:
	rm -f main *.o a.out
