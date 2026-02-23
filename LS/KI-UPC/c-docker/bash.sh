#!/bin/bash
# open bash shell in the container

CNAME="upc-dev-container"

echo $CNAME "..."
docker exec -it $CNAME /bin/bash
echo "..." $CNAME
