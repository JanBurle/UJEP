CC = cc
CFLAGS = -std=c11 -Wall -Wextra

.PHONY: all run clean

all: main

main: main.o funs.o scope.o
	$(CC) $(CFLAGS) -o $@ $^

%.o: %.c %.h
	$(CC) $(CFLAGS) -c -o $@ $<

run: all
	./main

clean:
	rm -f main *.o a.out
