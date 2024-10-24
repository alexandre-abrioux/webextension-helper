SHELL := /usr/bin/env bash
.DEFAULT_GOAL := help

include .env.dist
-include .env
export

.PHONY: help
help:		## This help message
	@echo -e "$$(grep -hE '^\S+:.*##' $(MAKEFILE_LIST) | sed -e 's/:.*##\s*/:/' -e 's/^\(.\+\):\(.*\)/\\x1b[36m\1\\x1b[m:\2/' | column -c2 -t -s :)"

.PHONY: build
build: 		## Buid docker services
	docker compose build

.PHONY: up
up: 		## Deploy docker services
	docker compose up -d --remove-orphans

.PHONY: stop
stop: 		## Stop docker services
	docker compose stop

.PHONY: down
down: 		## Remove docker services
	docker compose down --volumes

.PHONY: restart
restart: 	## Restart docker services
	docker compose restart

.PHONY: sign
sign:		## Sign the webextension with Mozilla's web-ext tool
	bin/sign $(ARGS)

.PHONY: update
update:		## Update Mozilla's web-ext tool
	docker compose build --no-cache web-ext
