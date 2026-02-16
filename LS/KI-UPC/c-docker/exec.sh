#!/bin/bash
# run command in the container
docker exec -w /src/hello cpp-dev-container "$@"
