DC := docker-compose -f ./docker/docker-compose.yml --env-file ./www/.env
APP := $(DC) exec -i app

build:
	@$(DC) build

start:
	@$(DC) up -d

stop:
	@$(DC) down

fix:
	@$(APP) vendor/bin/pint --config pint.json

ssh:
	@$(APP) bash

composer-install:
	@$(APP) composer install

key:
	@$(APP) php artisan key:generate

db-seed:
	@$(APP) php artisan migrate:fresh --seed

env:
	cp ./www/.env.example ./www/.env

test:
	@$(APP) php artisan test