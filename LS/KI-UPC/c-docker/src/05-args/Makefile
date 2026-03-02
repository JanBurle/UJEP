CC = cc
CFLAGS = -std=c11 -Wall -Wextra

.PHONY: all run clean

all: main

main: main.c
	$(CC) $(CFLAGS) -o main $^

run: all
	@echo "Running main..."
	./main a b c 3 "Hello, World!"

clean:
	rm -f main *.o a.out
