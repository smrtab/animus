# Apartments management interface
### Description
Dockerized stack for further eventual leveraging. It is a complete system being built along with following images:
```
* nginx:latest
* php:7.1-fpm
* postgres:latest
```
For the simplification purposes I have combined client side, server side and msmtp server into the the one container. Project leverages next frameworks:
```
* Angular 5 as a frontend
* Symfony 3.3 as a backend
```

All of docker-concerning files such as php.ini, nxinx.conf and etc are dwell in the __build folder.
For convenience' sake you only should fire an Makefile script which will build project (including restoring of node_modules, vendor folders and etc), build images and eventually spin up containers
But before makefile you need to decide about mailer engine real work:

```
If you want a real messages delivery you should manually configure file at ./__build/msmtprc
```

### Requirements
```
1) Established npm package manager 
2) Established ng module
3) Docker engine with docker-compose orchestration
4) Established make utility command for linux (for Windows it would be cmake, mingw32-make or another)
```
After makefile you may check spinned up containers by invoke "docker-compose ps" command.
```
Nginx is configured to be forwarded on 80 port of the Docker host, so you can check if such a port is free or manually specify it in docker-compose.yml 
```
For convenience' sake all logs from containers are mounted to Docker host in root's logs folder of project.
Logs are separated to app/, nginx/, /msmtp folders

### TODO
Due to development state of projects and therefore it lacks some useful feature:
1) Stronger validation on client side and server side
2) TDD integration if possible at the moment
3) Host mail server in the another Docker image

