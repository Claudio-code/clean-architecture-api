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

migrate-diff:
	cli/console doctrine:migrations:diff

test:
	cli/tests
