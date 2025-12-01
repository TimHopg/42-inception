#!/bin/bash
cd /var/www/html

# Read secrets from mounted files
WP_ADMIN_USER=$(cat ${WP_ADMIN_USER_FILE:-/run/secrets/wp_admin_user})
WP_ADMIN_PASSWORD=$(cat ${WP_ADMIN_PASSWORD_FILE:-/run/secrets/wp_admin_password})
DB_PASSWORD=$(cat ${DB_PASSWORD_FILE:-/run/secrets/db_password})

# Only initialize if WordPress isn't already installed
if [ ! -f "wp-load.php" ]; then
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
    chmod +x wp-cli.phar
    ./wp-cli.phar core download --allow-root
    ./wp-cli.phar config create --dbname=${DB_NAME} --dbuser=${DB_USER} --dbpass="${DB_PASSWORD}" --dbhost=${DB_HOST} --allow-root
    ./wp-cli.phar core install --url=localhost --title="${WP_TITLE}" --admin_user="${WP_ADMIN_USER}" --admin_password="${WP_ADMIN_PASSWORD}" --admin_email="${WP_ADMIN_EMAIL}" --allow-root
    ./wp-cli.phar theme activate astra --allow-root
    ./wp-cli.phar plugin install elementor --activate --allow-root
    ./wp-cli.phar user create user2 user2@inception.42.fr --user_pass=user2pass --role=subscriber --allow-root
fi

# Run php-fpm in foreground and exit with its exit code
php-fpm8.2 -F