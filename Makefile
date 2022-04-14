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

generate-keypair:
	docker exec -it clean-architecture-api php bin/console lexik:jwt:generate-keypair --skip-if-exists

migrate:
	echo "Agora vamos entrar no sleep para que o banco possa iniciar ..."
	sleep 20
	echo "Voltamos dos reclames do plim plim :)"
	docker exec -it clean-architecture-api php bin/console doctrine:migrations:migrate --no-interaction

startup: build migrate generate-keypair test
