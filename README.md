## BuddySchoolCrawler

Application for crawling BuddySchool site.
Allows to search article and download dumped to text file.

### Technology stack
* PHP: 7.2.*
* Symfony 4.0.6
* Docker
* PHPUnit 7.0.2

#### Continous Integration
* Travis

### Docker build
```
$ docker-compose up -d
$ docker exec -it bscrawler-php-fpm bash
$ composer install
```

### Launch app
`http://localhost:7777/`

--- 

### Previous versions (switch branch)
* master
* v0.1 (PHP: 7.1.6, Symfony 3.3.6)