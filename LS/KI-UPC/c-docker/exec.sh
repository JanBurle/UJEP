#!/bin/bash
# run command in the container

CNAME="upc-dev-container"

docker exec -w /src/01-hello $CNAME "$@"
