OroCRM 3.6 starter - Docker
===

## Install with DOCKER
Install docker [here](https://docs.docker.com/compose/install/#prerequisites)
```
$ make install
```

#### Vhost
```
127.0.0.1 orocrm.local
```

#### Test website
Go to [login page](https://orocrm.local/user/login) (admin@admin.com / admin)

#### Email: Mailhog
Go [here](http://localhost:8025/) to see all mails sent.

## Good to know
#### Reset installation

- set parameter `installed: false` in config/parameters.yml.
- remove cache
- launch:`
```
$ make oro-install
```


## Know issues
```
Class Extend\Entity\EX_OroLocaleBundle_Localization does not exist
```
Launch:
```
$ make oro-warmup-cache
```
---
```
The process "'/usr/local/bin/php' 'bin/console' 'oro:requirejs:build' '--no-debug'" exceeded the timeout of 2000 seconds.
```
Launch:
```
$ make assets
```
