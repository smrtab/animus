node_version:=$(shell node -v)
npm_version:=$(shell npm -v)
timeStamp:=$(shell date +%Y%m%d%H%M%S)


.PHONY: show install build composer docker-compose

all: show install build composer docker-compose

show:
		@ echo Timestamp: "$(timeStamp)"
		@ echo Node Version: $(node_version)
		@ echo npm_version: $(npm_version)

install:
		@ echo "npm  install"
		@ cd source; npm install

build:
		@ echo "building in production mode"
		@ cd source; ng build --prod -op ../client
		
composer:
		@ echo "run composer"
		@ cd server; composer install		
		
docker-compose:
		@ echo "run docker-compose"
		@ cd __build; docker-compose up -d --build
		@ cd __build; docker-compose exec php php bin/console --no-interaction doctrine:migration:migrate