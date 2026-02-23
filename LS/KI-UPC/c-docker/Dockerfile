FROM debian:stable-slim

# terminal prompt, aliases
RUN cat >> /root/.bashrc << EOT
PS1='\[\033[01;33m\]$\[\033[01;32m\]\W\[\033[00m\] '
alias ls='ls --color=auto'
alias ll='ls -l --color=auto'
EOT

# install C compiler and tools
RUN apt-get update && apt-get install -y \
    make gcc binutils gdb gdbserver \
    libcomerr2 mc vim nano \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /src

# keep container running
CMD ["/bin/bash"]
