# C programming

## Docker

#### Build and start the container

```bash
docker-compose up -d
```

#### Open terminal inside container

```bash
./bash.sh
```

#### Inside the container

compile and run

```bash
# cd /src
# make clean
# make all
# make clean all
make
./main
```

inspect object files

```bash
gcc -c main.c -o main.o
gcc main.o -o main
objdump -h main.o
objdump -x main.o
objdump -d main.o
objdump -d -M intel main.o
ldd main
nm -C main.o
strings main.o
mcview main.o
```

## Debugging

Dev Containers attach to running container

Install extension in container

Reload

Open terminal (it is in container)

Debug



## Docs

- [GCC Documentation](https://gcc.gnu.org/onlinedocs/)
- [GDB Documentation](https://sourceware.org/gdb/documentation/)
- [Docker Documentation](https://docs.docker.com/)
- [VSCode C/C++ Extension](https://code.visualstudio.com/docs/languages/cpp)

## ⚙️ Advanced Configuration

### Custom Compiler Flags

Edit `src/Makefile` and modify `CFLAGS` or `CXXFLAGS`:

```makefile
CFLAGS = -g -Wall -Wextra -O2 -std=c11
```

### Installing Additional Tools

Edit `Dockerfile` and add packages:

```dockerfile
RUN apt-get update && apt-get install -y \
    build-essential \
    gdb \
    gdbserver \
    your-additional-package \
    && apt-get clean
```

Then rebuild: `docker-compose build`

---

**Happy Coding! 🎉**
