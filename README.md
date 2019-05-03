OroCRM 3.6 starter - Docker
===

## Install with DOCKER
Install docker [here](https://docs.docker.com/compose/install/#prerequisites)
```
$ make          # self documented makefile
$ make install  # install and start the project
```

#### Vhost
```
127.0.0.1 orocrm.local
```

#### Test website
Go to [login page](https://orocrm.local/user/login) (admin@orocrm.com / admin)

#### Email: Mailhog
Go [here](http://localhost:8025/) to see all mails sent.

## Know issues
```
Class Extend\Entity\EX_OroLocaleBundle_Localization does not exist
```
Launch:
```
$ docker-compose exec redis redis-cli -p 6379 flushall
$ docker-compose exec language php bin/console oro:entity-extend:cache:warmup
```
---
```
The process "'/usr/local/bin/php' 'bin/console' 'oro:requirejs:build' '--no-debug'" exceeded the timeout of 900 seconds.
```
Launch:
```
$ make assets
```
