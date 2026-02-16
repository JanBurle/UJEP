# !/bin/bash
for d in $(ls -d */); do
    (cd "$d" && make clean)
done
