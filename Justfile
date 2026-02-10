set dotenv-load := true
sail := "./vendor/bin/sail"

default:
	@just --list

up:
	{{sail}} up -d

down:
	{{sail}} down

restart:
	{{sail}} down
	{{sail}} up -d

logs:
	{{sail}} logs -f

sh:
	{{sail}} shell

artisan *args:
	{{sail}} artisan {{args}}

composer *args:
	{{sail}} composer {{args}}

npm *args:
	{{sail}} npm {{args}}

serve:
	{{sail}} npm run dev -- --host

build:
	{{sail}} npm run build

migrate:
	{{sail}} artisan migrate

fresh:
	{{sail}} artisan migrate:fresh --seed

test:
	{{sail}} test

clear:
	{{sail}} artisan config:clear
	{{sail}} artisan cache:clear
	{{sail}} artisan config:cache

bootstrap:
	just up
	just composer install
	just npm install
	just artisan key:generate
	just migrate
