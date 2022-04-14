start:
	docker-compose up -d

build:
	docker-compose up -d --build

down:
	docker-compose down

stop:
	docker-compose stop

rm:
	docker-compose rm

migrate-diff: start
	cli/console doctrine:migrations:diff

test: start
	cli/tests

migrate-startup: start
	cli/migrate-startup

generate-keypair:
	docker exec -it clean-architecture-api php bin/console lexik:jwt:generate-keypair --skip-if-exists

migrate:
	docker exec -it clean-architecture-api php bin/console doctrine:migrations:migrate --no-interaction

startup: build migrate-startup generate-keypair test
