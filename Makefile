# Fichier Makefile à mettre à la racine du projet

PHP_CONTAINER=hiba_php

# Symfony
cache:
	docker exec -it $(PHP_CONTAINER) php bin/console cache:clear

migrate:
	docker exec -it $(PHP_CONTAINER) php bin/console doctrine:migrations:migrate

test:
	docker exec -it $(PHP_CONTAINER) ./vendor/bin/phpunit

# Composer
composer-install:
	docker exec -it $(PHP_CONTAINER) composer install

# Permissions (utile sur Linux)
fix-perms:
	sudo chown -R $$(id -u):$$(id -g) .
