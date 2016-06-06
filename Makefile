COMPOSER_DEV = 

# start docker composer
preComposer:
	docker pull composer/composer

# start composer update
composer:preComposer
	docker run --rm -v $(PWD):/app composer/composer update --ignore-platform-reqs --prefer-dist -o $(COMPOSER_DEV)


