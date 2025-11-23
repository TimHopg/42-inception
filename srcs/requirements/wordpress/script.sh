#!/bin/bash
cd /var/www/html
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar # command line wordpress control
chmod +x wp-cli.phar
./wp-cli.phar core download --allow-root
./wp-cli.phar config create --dbname=wordpress --dbuser=wpuser --dbpass=password --dbhost=mariadb --allow-root
./wp-cli.phar core install --url=localhost --title=inception --admin_user=admin --admin_password=admin --admin_email=admin@admin.com --allow-root

# Activate astra theme
./wp-cli.phar theme activate astra --allow-root

# Delete defaults
./wp-cli.phar theme delete twentytwentyfive --allow-root
./wp-cli.phar theme delete twentytwentyfour --allow-root
./wp-cli.phar theme delete twentytwentythree --allow-root

# Elementor for page building
./wp-cli.phar plugin install elementor --activate --allow-root

php-fpm8.2 -F