FROM debian:oldstable

# Install NGINX and OpenSSL (for HTTPS (TLS) certificates)

RUN apt update && \
    apt upgrade -y && \
    apt install -y \
    nginx \
    openssl && \
    # cleanup
    apt clean && rm -rf /var/lib/apt/lists/*

# Create directories for NGINX. One for website files and the other for SSL certificates

RUN mkdir -p /var/www/html
RUN mkdir -p /etc/nginx/ssl

# Tells docker this container listens on port 443

EXPOSE 443

# Starts nginx in the foreground 

CMD ["nginx", "-g", "daemon off;"]
