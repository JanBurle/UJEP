docker stop $(docker ps -q)     2> /dev/null
docker rm $(docker ps -aq)      2> /dev/null
docker rmi $(docker images -q)  2> /dev/null
docker volume prune -f          1> /dev/null
