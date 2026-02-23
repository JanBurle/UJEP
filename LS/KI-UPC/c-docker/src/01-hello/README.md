# Hello World in C

## [gcc](https://en.wikipedia.org/wiki/GNU_Compiler_Collection) compiler

```bash
which cc
ll `which cc` # ll $(which cc) --> gcc
```

- [main.c](./main.c)

compile, run, inspect object files

```bash
gcc -c main.c -o main.o
gcc main.o -o main
objdump -h main.o # show section headers
objdump -x main.o # show all headers (including symbol table)
objdump -d main.o # disassemble code section (default is intel syntax)
objdump -d -M intel main.o # disassemble code section in intel syntax
ldd main # show shared library dependencies (not applicable for static binaries)
nm -C main.o # show symbol table (demangle C++ names with -C)
strings main.o # show printable strings in the binary (useful for debugging)
mcview main.o # show machine code in a more readable format (requires mcview tool)
```

## [make](<https://en.wikipedia.org/wiki/Make_(software)>) tool

[Makefile](./Makefile)

```bash
make
./main
# make clean
# make all
# make clean all
```

## Debugging

- [GCC Documentation](https://gcc.gnu.org/onlinedocs/)
- [GDB Documentation](https://sourceware.org/gdb/documentation/)
- [Docker Documentation](https://docs.docker.com/)
- [VSCode C/C++ Extension](https://code.visualstudio.com/docs/languages/cpp)
