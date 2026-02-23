CC = cc
CFLAGS = -std=c11 -Wall -Wextra

.PHONY: all clean

all: lower double

CFLAGS += -D NOBUFFER

%.o: %.c
	$(CC) $(CFLAGS) -c -o $@ $<

lower: lower.o io.o
	$(CC) $(CFLAGS) -o lower $^

double: double.o io.o
	$(CC) $(CFLAGS) -o double $^

clean:
	rm -f lower double *.o a.out
