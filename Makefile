init: docker-down-clear docker-pull docker-build-pull docker-up app-init
down: docker-down-clear
lint: app-lint
test: test-unit test-functional

docker-up:
	docker-compose up -d

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build-pull:
	docker-compose build --pull

app-init: app-permissions composer-install app-migrations

composer-install:
	docker-compose run --rm php-cli composer install

app-migrations:
	docker-compose run --rm php-cli composer app migrations:migrate -- --no-interaction

validate-schema:
	docker-compose run --rm php-cli composer app orm:validate-schema

app-permissions:
	docker run --rm -v ${PWD}:/app -w /app alpine chmod 777 public var/log -R

composer-update:
	docker-compose run --rm php-cli composer update

app-lint:
	docker-compose run --rm php-cli composer lint

test-unit:
	docker-compose run --rm php-cli composer test -- --testsuite unit

test-functional:
	docker-compose run --rm php-cli composer test -- --testsuite functional
