SAILS = ./vendor/bin/sail

.PHONY: up down restart shell logs build artisan

args = $(filter-out $@,$(MAKECMDGOALS))

up:
	$(SAILS) up -d

down:
	$(SAILS) down

restart:
	$(SAILS) restart

shell:
	$(SAILS) shell

logs:
	$(SAILS) logs -f

build:
	$(SAILS) build --no-cache

artisan:
	$(SAILS) artisan $(args)

%:
	@: