CC = cc
CFLAGS = -std=c11 -Wall -Wextra

.PHONY: all run clean

all: pointers params strings

pointers: pointers.o
	$(CC) $(CFLAGS) -o $@ $^

params: params.o
	$(CC) $(CFLAGS) -o $@ $^

strings: strings.o
	$(CC) $(CFLAGS) -o $@ $^

%.o: %.c %.h
	$(CC) $(CFLAGS) -c -o $@ $<

run: strings
	./strings

clean:
	rm -f pointers params strings *.o a.out
