.PHONY: run stop start down db

build:
	docker-compose build

run:
	docker-compose up
	docker-compose exec php chown -R www-data:www-data /var/cache && sudo rm -rf /var/cache/*
	docker-compose exec php chown -R www-data:www-data var/logs

run-doctrine:
	docker-compose exec php php bin/console doctrine:schema:update --force 2>/dev/null; true
	docker-compose exec php php bin/console cache:clear 2>/dev/null; true
stop:
	docker-compose stop
start:
	docker-compose up -d
down:
	docker-compose down
ps:
	docker ps
