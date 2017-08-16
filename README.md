## BuddySchoolCrawler
* PHP: 7.1.6
* Symfony 3.3.6
* Docker

### Docker build
* build
  * `mkdir web/files`
  * `docker-compose build`
  * `docker-compose up -d`

* composer
  * `docker-compose run --rm composer CMD` 
    * i.e. `docker-compose run --rm composer install`
  
### tools
   * console
        * connect to php container
        `docker exec -it bscrawler-php-fpm bash`