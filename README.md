# Inception

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

## Workflow

- Build a Dockerfile for each image you wish to add.
- Use Docker Compose to assemble the images with the `build` command

