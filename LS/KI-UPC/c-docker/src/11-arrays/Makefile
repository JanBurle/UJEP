CC = cc
CFLAGS = -std=c11 -Wall -Wextra

.PHONY: all run clean

all: pointers params

pointers: pointers.o
	$(CC) $(CFLAGS) -o $@ $^

params: params.o
	$(CC) $(CFLAGS) -o $@ $^

%.o: %.c %.h
	$(CC) $(CFLAGS) -c -o $@ $<

run: pointers
	./pointers

clean:
	rm -f pointers params *.o a.out
