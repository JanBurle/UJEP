# Makefile for C/C++ projects

# C compiler
CC = gcc
CFLAGS = -std=c11 -g -Wall -Wextra	# debug symbols, all warnings
# CFLAGS = -Wall -Wextra	# nodebug
# -O2 -std=c11

# C++ compiler
# CXX = g++
# CXXFLAGS = -g -Wall -Wextra

# Targets

# mark these as commands, not files
.PHONY: all clean

# default target to build the main executable
all: main

# compile main.c into an executable named main
main: main.c
	$(CC) $(CFLAGS) -o main $^

# clean up build artifacts
clean:
	rm -f main *.o

# SOURCES = main.c utils.c helper.c
# OBJECTS = $(SOURCES:.c=.o)
# TARGET = main

# all: $(TARGET)

# $(TARGET): $(OBJECTS)
# 	$(CC) $(CFLAGS) -o $@ $^

# %.o: %.c
# 	$(CC) $(CFLAGS) -c $<

# clean:
# 	rm -f $(TARGET) $(OBJECTS)
