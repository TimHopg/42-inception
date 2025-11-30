# Inception - Docker WordPress Infrastructure

## Quick Summary

We're creating a WordPress hosting infrastructure using Docker. Here's what each service does:

NGINX - The web server that receives HTTP/HTTPS requests from users and forwards PHP requests to WordPress. Run on port 443 for HTTPS.
WordPress (PHP-FPM) - The application server that generates web pages (PHP-FPM is "PHP FastCGI Process Manager"). Runs on port 9000 as default.
MariaDB - The database that stores all WordPress content (posts, users, settings). Runs on port 3306 as the default assigned by MySQL (MariaDB is a fork of MySQL).
They communicate through a Docker network, and persist data in volumes.

## Introduction

This project aims to broaden your knowledge of system administration through the use of Docker technology.
You will virtualize several Docker images by creating them in your new personal virtual machine.

## General guidelines

- This project must be completed on a Virtual Machine.
- All the files required for the configuration of your project must be placed in a srcs folder.
- A Makefile is also required and must be located at the root of your directory. It must set up your entire application (i.e., it has to build the Docker images using docker-compose.yml).
- This subject requires putting into practice concepts that, depending on your background, you may not have learned yet. Therefore, we advise you to read extensive documentation related to Docker usage, as well as any other resources you find helpful to complete this assignment.

## Project Brief

This project involves setting up a small infrastructure composed of different services under specific rules. The whole project has to be done in a __virtual machine__.
You must use Docker Compose.  
Each __Docker image__ must have the __same name__ as its __corresponding service__.  
Each service has to run in a __dedicated container__.  
For performance reasons, the containers must be built from either the penultimate stable version of `Alpine` or `Debian`. The choice is yours.  
You also have to write your own Dockerfiles, one per service. The Dockerfiles must be called in your docker-compose.yml by your Makefile.
This means you must build the Docker images for your project yourself. It is then forbidden to pull ready-made Docker images or use services such as DockerHub (Alpine/Debian being excluded from this rule).

You then have to set up:

- A Docker container that contains NGINX with TLSv1.2 or TLSv1.3 only.
- A Docker container that contains WordPress with php-fpm (it must be installed and configured) only, without nginx.
- A Docker container that contains only MariaDB, without nginx.
- A volume that contains your WordPress database.
- A second volume that contains your WordPress website files.
- A docker-network that establishes the connection between your containers.

Your containers must restart automatically in case of a crash.
A Docker container is not a virtual machine. Thus, it is not recommended to use any hacky patches based on ’tail -f’ and similar
methods when trying to run it.
Read about how daemons work and whether it’s a good idea to use them or not.

## Docker

### Docker Architecture

The Docker architecture (of images) is made up of layers. The bottom layer is the physical server which is used to host virtual machines. This is the same as the traditional virtualisation architecture.

The next layer is the Host OS (e.g. Debian (Linux)). Then the Docker Engine which is used to run the operating system. Above that are apps which are run as Docker containers. Docker objects are made up of Images and Containers.

### Images and Containers

- An __Image__ is a sort of class, or recipe (& ingredients) or blueprint. It is made up of read only layers.
- And a __Container__ is an object, an instance of that class, the baked cake or the constructed object.

Containers are isolated systems that hold everything required to run a specific application. It's a specific instance of an image that simulates the necessary environment.

Images are used to start up containers. If you modify a container, install new software, change files inside it, you can use docker commit to save those changes as a new image. You can snapshot a container to create a new image. (This might not be useful for this project.)

Images can be pre-built, retrieved from registries like DockerHub, created from existing ones or combined together to form a network.

### Dockerfiles

A dockerfile is a text document that contains the commands to be called on the command line to build and image.

Dockerfiles are built in layers:

- `FROM` keyword defines which pre-built image we use to build our image (Alpine/Debian etc.)
- Then we define our user permissions and startup scripts

A Docker container adds a writable layer ontop of the image's read-only layers.

When docker is installed a default bridge named `docker0` is created. Each new container is automatically attached to this network unless a custom network is specified.

Besides `docker0`, `host` (no isolation between host and containers on this network) and `none` (attached containers run on container-specific network stack).

### Docker Compose

A tool for defining and running multi-container Docker applications.
You use a YAML file to configure the application's services. `docker-compose.yml`
Then you can start all the services from the configuration in a single command.

One of the Docker Compose functions is to build images from Dockerfiles.

Basic structure for a Docker Compose file

```dockercompose
version: 'X'

services:
  web:
    build: .
    ports:
     - "5000:5000"
    volumes:
     - .:/code
  redis:
    image: redis
```

## Installing Docker

- Install the Docker engine

## Workflow (this is without TSL ecryption and env variables)

- Build a Dockerfile for each image you wish to add.
- Use Docker Compose to assemble the images with the `build` command.

```plaintext
../inception/
├── docker-compose.yml
└── requirements
    └── nginx
        └── Dockerfile
```

- docker-compose.yml file in our projects root directory on the virtual machine.
- A requirements folder that contains folders for our containers for our Dockerfile and service specific config files.
- NGINX service in our docker-compose file:

```yml
version: "3.8" # deprecated, version now not needed

services:
  nginx:
    build: requirements/nginx/.
    container_name: nginx
    ports:
      - "80:80"
```

- NGINX Dockerfile:

```dockerfile
FROM debian:latest

RUN apt update && apt upgrade && apt install -y nginx

CMD ["nginx", "-g", "daemon off;"]
```

- `-g` runs the process in the foreground. This way

## Docker Commands

`docker compose up --build` - `up` starts all services defined in the docker compose file. `--build` flag forces build/rebuild of the images for the services, using instructions in Dockerfiles. You can run without `--build` if no changes have been made(?).

## NGINX

High performance web server and reverse proxy.

`-g` - set global configuration directives
`"daemon-off"` - runs NGINX in the foreground

<https://nginx.org/en/docs/switches.html>

## MariaDB

## WordPress

- Two users: Admin (with appropriate password) and another.

## PID 1

A Docker container only stays running as long as their main process (PID 1) is running in the foreground. Running our services in the foreground means Docker can manage, monitor and restart the container when needed.

## TLS & SSL

TLS is a cryptographic protocol to secure data. TLS is the lock and HTTPS is the door that uses that lock.
SSL (Secure Sockets Layer) was the original protocol for securing web connections, but has been largely replaced by TLS due to security vulnerabilities. Modern HTTPS connections use TLS.
When you visit a `https://` website, your browser uses HTTP wrapped in TLS to ensure the data is encrypted and secure.

A TLS handshake is initiated with the server, they agree on encryption methods and exchange keys.
Once a secure channel is established, HTTP traffic flows through it, this is HTTPS.

SSL certificates (also called TLS certificates) contain the public key and identity information used during the TLS handshake. Despite the name, these certificates work with both SSL and TLS protocols.

v1.2 / v1.3 - v1.2 is the older but still secure version and v1.3 is the new version with performance improvements.

## Docker Secrets

Docker secrets securely store sensitive information like passwords and API keys. In this project:

- Secrets are stored in files in the `secrets/` directory
- Files are read by containers at runtime via `/run/secrets/filename`
- The `secrets/` folder is gitignored for security
- Required secret files:
  - `db_password.txt` - Database user password
  - `db_root_password.txt` - Database root password
  - `wp_admin_user.txt` - WordPress admin username
  - `wp_admin_password.txt` - WordPress admin password

A secure way to manage sensitive data like passwords and API keys.
Environment variables can be seen in logs.
Secrets are:

- Encrypted at rest
- Only accessible in containers that explicitly declare them
- Mounted as files inside containers at runtime
- Not visible in logs or environment variabls

## docker-network

## Checklist

[] Volumes available in `/home/<login>/data` of the host machine using Docker. Replace `<login>` with your own.
[] Configure your domain name to point to your local IP address. `<login>.42.fr` (`thopgood.42.fr`).
[] `latest` tag is prohibited.
[] No Passwords in Dockerfiles.
[] Use a `.env` file to store environment variables (non-sensitive).
[] Use Docker secrets to store confidential information (passwords, keys).
[] NGINX container is the sole entry point into your infrastructure via port 443, using TLS v1.2 or v1.3 protocol.

## Potential Issues

- Main problem is keeping the container alive. Unless there is a foreground process, it will exit.
- Bash script to create the website for wordpress.
- At the end of the script, one line launches the process in the foreground.
- So NGINX must be launched without daemonising. There is a command for this.

## Resources

- <https://docs.docker.com/>
- <https://nginx.org/en/docs/>

## Notebook

To configure the local domain to forward `thopgood.42.fr` to `localhost`. `sudo` grants super user permissions only to the command immediately after so this opens a shell and runs the `echo` command that follows `-c`.
`sudo sh -c 'echo "127.0.0.1 thopgood.42.fr" >> /etc/hosts'`

Behind the scenes, the computer will no longer ask DNS servers to resolve the IP of `thopgood.42.fr` and instead will immedaitely resolve to `127.0.0.1`.

`docker exec wordpress killall -9 php-fpm8.2`
