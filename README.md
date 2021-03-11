- clone this repo
- `composer install`
- duplicate .env.example and rename to .env
- `php artisan key:generate`
- `docker-compose up -d`
- [http://0.0.0.0](http://0.0.0.0)
- World has a width: 200 and height: 200, you should be able to move between that limit.
- You also can run some feature test 
    - `./vendor/bin/phpunit`