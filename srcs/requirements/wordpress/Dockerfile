# Create a PHP-FPM application server that runs WordPress

FROM debian:oldstable

# Install PHP-FPM and required modules

RUN apt update && \
    apt upgrade -y && \
    apt install -y \
    php-fpm \
    php-mysql \
    php-cli \
    php-curl \
    php-dom \
    php-imagick \
    php-mbstring \
    php-zip \
    curl && \
    # cleanup
    apt clean && \
    rm -rf /var/lib/apt/lists/*

COPY www.conf /etc/php/8.2/fpm/pool.d/.

# Create directory for website files        

RUN mkdir -p /var/www/html
RUN mkdir -p /run/php

COPY themes/astra /var/www/html/wp-content/themes/astra

# default port for PHP-FPM (fast CGI process manager)
EXPOSE 9000

COPY script.sh .
RUN chmod +x script.sh
CMD ["./script.sh"]
