# Dockerfile for WordPress service# Start from Debian oldstable (lightweight base image)FROM debian:oldstable

# Purpose: Create a PHP-FPM application server that runs WordPress

FROM debian:oldstable

FROM debian:oldstable

RUN apt update && \

# Install PHP-FPM and required modules

RUN apt update && \# Install PHP-FPM (FastCGI Process Manager for PHP) and MySQL client    apt upgrade -y && \

    apt upgrade -y && \

    apt install -y \RUN apt update && apt install -y php-fpm php-mysqli    apt install -y \

    php-fpm \

    php-mysql \        php-fpm \

    php-cli \

    curl && \# Expose port 9000 (PHP-FPM default port)        php-mysqli \

    apt clean && \

    rm -rf /var/lib/apt/lists/*EXPOSE 9000        php-curl \



# Create directory for website files        php-dom \

RUN mkdir -p /var/www/html

# Run PHP-FPM in foreground mode        php-imagick \

# Create PHP-FPM run directory

RUN mkdir -p /run/php# This keeps the container running        php-mbstring \



EXPOSE 9000CMD ["php-fpm8.2", "-F"]        php-zip \



# Start PHP-FPM in foreground        php-gd \

CMD ["php-fpm8.2", "-F"]        curl \

        wget \
        mariadb-client && \
    apt clean && \
    rm -rf /var/lib/apt/lists/*

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

COPY www.conf /etc/php/8.2/fpm/pool.d/www.conf
COPY wordpress.sh /usr/local/bin/wordpress.sh

RUN chmod +x /usr/local/bin/wordpress.sh && \
    mkdir -p /var/www/html /run/php && \
    chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["/usr/local/bin/wordpress.sh"]
