FROM  daocloud.io/1514582970/pms_docker_php:cli71_swoole_phalcon

MAINTAINER      Dongasai "1514582970@qq.com"

RUN apt update;apt install -y vim
COPY . /var/www/html/

ENV APP_SECRET_KEY="123456"

ENV GCACHE_HOST="192.168.1.220"
ENV GCACHE_PORT="6379"
ENV GCACHE_AUTH=0
ENV GCACHE_PERSISTENT=""
ENV GCACHE_PREFIX="register"
ENV GCACHE_INDEX="1"

ENV MYSQL_HOST="192.168.1.220"
ENV MYSQL_PORT="3306"
ENV MYSQL_DBNAME="register"
ENV MYSQL_PASSWORD="123456"
ENV MYSQL_USERNAME="register"

EXPOSE 9502
WORKDIR /var/www/html/
RUN composer install
CMD php start/start.php

