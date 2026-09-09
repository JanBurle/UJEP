CC = cc # default C compiler, link to gcc
# CFLAGS =
# CFLAGS = -Wall -Wextra
CFLAGS = -std=c11 -g -Wall -Wextra

.PHONY: all clean

# default (first) target to build the main executable
all: main

# compile main.c into an executable named main
main: main.c
	$(CC) $(CFLAGS) -o main $^

# clean up build artifacts
clean:
	rm -f main *.o a.out
