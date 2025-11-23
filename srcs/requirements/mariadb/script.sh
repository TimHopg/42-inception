#!/bin/bash

# Initialize MariaDB data directory only if not already done
if [ ! -d "/var/lib/mysql/mysql" ]; then
    mysql_install_db --user=mysql --datadir=/var/lib/mysql
fi

exec mysqld --user=mysql
