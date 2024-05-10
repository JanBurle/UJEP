PS=$(docker ps -q)
[ "$PS" ] && docker stop $PS
docker system prune -af --volumes > /dev/null
