#!/bin/bash

# Read passwords from secrets
DB_PASSWORD=$(cat ${MYSQL_PASSWORD_FILE:-/run/secrets/db_password})
DB_ROOT_PASSWORD=$(cat ${MYSQL_ROOT_PASSWORD_FILE:-/run/secrets/db_root_password})

# Initialize MariaDB data directory if not there
if [ ! -d "/var/lib/mysql/mysql" ]; then
    mysql_install_db --user=mysql --datadir=/var/lib/mysql
fi

# Create initialization SQL file
cat > /tmp/init.sql <<EOF
CREATE DATABASE IF NOT EXISTS ${MYSQL_DATABASE};
CREATE USER IF NOT EXISTS '${MYSQL_USER}'@'%' IDENTIFIED BY '${DB_PASSWORD}';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER ON ${MYSQL_DATABASE}.* TO '${MYSQL_USER}'@'%';
FLUSH PRIVILEGES;
EOF

# Run MariaDB with init-file to execute SQL at startup
exec mysqld --user=mysql --init-file=/tmp/init.sql
