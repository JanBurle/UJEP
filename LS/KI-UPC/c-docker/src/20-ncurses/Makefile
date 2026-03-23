CC = cc
CFLAGS = -std=c11 -Wall -Wextra
LDLIBS = -lncurses

.PHONY: all run clean

all: hello1 hello2 hello3

hello1: hello1.o
	$(CC) $(CFLAGS) -o $@ $^ $(LDLIBS)

hello2: hello2.o
	$(CC) $(CFLAGS) -o $@ $^ $(LDLIBS)

snakes: snakes.o
	$(CC) $(CFLAGS) -o $@ $^ $(LDLIBS)

%.o: %.c %.h
	$(CC) $(CFLAGS) -c -o $@ $<

run: snakes
	./snakes

clean:
	rm -f hello1 hello2 snakes *.o a.out
