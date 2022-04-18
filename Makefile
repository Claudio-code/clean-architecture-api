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

doc: start
	python -mwebbrowser http://localhost:8000/doc

migrate-startup: start
	cli/migrate-startup

generate-keypair: start
	docker exec -it clean-architecture-api php bin/console lexik:jwt:generate-keypair --skip-if-exists

migrate: start
	docker exec -it clean-architecture-api php bin/console doctrine:migrations:migrate --no-interaction

startup: build migrate-startup generate-keypair test doc
