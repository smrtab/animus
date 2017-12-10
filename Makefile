node_version:=$(shell node -v)
npm_version:=$(shell npm -v)
timeStamp:=$(shell date +%Y%m%d%H%M%S)


.PHONY: install build archive test clean

show:
		@ echo Timestamp: "$(timeStamp)"
		@ echo Node Version: $(node_version)
		@ echo npm_version: $(npm_version)

install:
		@ npm install

build:
		echo "building in production mode"
		@ ng build --prod -op ../client

archive:
		@ tar -czvf client-$(timeStamp).tar.gz" ../client

test:
		echo "test the app"
		@ npm run test

clean:
		echo "cleaning the dist directory"
		@ rm -rf dist
		@ rm -rf dist.tar.gz

INFO := @bash -c '\
  printf $(YELLOW); \
  echo "=> $$1"; \
  printf $(NC)' SOME_VALUE