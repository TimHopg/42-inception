FROM debian:oldstable

RUN apt update && apt upgrade && apt install -y \
    mariadb-server && \
    apt clean && rm -rf /var/lib/apt/lists/*

COPY 50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf
COPY init.sql /etc/mysql/init.sql

RUN mkdir -p /run/mysqld && \
    chown -R mysql:mysql /var/lib/mysql /var/run/mysqld

# MariaDB's default port
EXPOSE 3306

COPY script.sh .
RUN chmod +x script.sh

# Run as mysql user (not root)
USER mysql

CMD ["./script.sh"]
