build:
	docker-compose up --build

up:
	docker-compose up

setup:
	docker-compose exec backend bash -c "php artisan migrate:fresh && php artisan db:seed"

sh:
	docker-compose exec backend bash

test-back:
	docker-compose exec backend bash -c "php artisan test"