FROM debian:oldstable

# Install NGINX and OpenSSL (for HTTPS (TLS) certificates)

RUN apt update && apt upgrade -y && \
    apt install -y nginx openssl && \
    # cleanup
    apt clean && rm -rf /var/lib/apt/lists/*

# Generate self-signed SSL certificate
RUN mkdir -p /etc/nginx/ssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/nginx/ssl/nginx.key \
    -out /etc/nginx/ssl/nginx.crt \
    -subj "/C=GB/ST=London/L=London/O=42/OU=inception/CN=thopgood.42.fr"

# Directory for website files
RUN mkdir -p /var/www/html

COPY default /etc/nginx/sites-available/.

# Tells docker this container listens on port 443

EXPOSE 443

# Starts nginx in the foreground 

CMD ["nginx", "-g", "daemon off;"]
