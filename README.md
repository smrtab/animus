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

From source/ folder it compiles output bundle of angular's files into client/ folder. Further they will be treat as static by nginx server.
Caching of static is disabled at the moment (sendfile = off)

Frontend is built under Angular5(angular-cli) version. There are components for list, add and edit apartments. The entire page is under apartment-list manage. Add component and edit are the modal ones.

Interacion between client and server performs with AuthToken verification. Every outgoing client's request is being signed by AuthToken header. Server side in turn check it inside middleware before resolve request further.

Server's REST API logic is built with FOSRestBundle.

### MAIL
1. Set your own account in msmptrc and mark it as default
2. Point your account in php.ini un section used for sendmail setting (sendmail_path = /usr/bin/msmtp -a gmail -t)
3. Rebuild php image (docker-compose stop && docker-compose build php && docker-compose up -d)

### TODO
Due to development state of projects and therefore it lacks some useful feature:
1) Stronger validation on client side and server side
2) TDD integration if possible at the moment
3) Host mail server in the another Docker image

