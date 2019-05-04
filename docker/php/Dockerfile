FROM php:7.2.17-fpm-alpine3.9

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG UID=${UID}
ARG GUID=${GUID}
ARG XDEBUG=${XDEBUG}

WORKDIR /srv/

RUN apk update
RUN apk add autoconf freetype-dev g++ icu-dev icu-libs libjpeg-turbo-dev libpng-dev libxml2-dev libxslt-dev libzip-dev make shadow tzdata tidyhtml-dev imap-dev


# Xdebug
RUN docker-php-ext-configure hash --with-mhash
RUN docker-php-ext-install -j$(nproc) bcmath gd intl opcache pdo_mysql soap xsl zip exif pdo soap tidy imap

RUN apk add --upgrade apk-tools
RUN docker-php-ext-configure imap --with-imap
RUN docker-php-ext-configure intl --enable-intl

#RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/testing/ gnu-libiconv-dev && \
#(mv /usr/bin/gnu-iconv /usr/bin/iconv; mv /usr/include/gnu-libiconv/*.h /usr/include; rm -rf /usr/include/gnu-libiconv)

RUN pecl install xdebug-2.7.1
COPY conf/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN if [ $XDEBUG = "true" ] ; then \
docker-php-ext-enable xdebug; \
fi ;

COPY conf/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# PHP config
COPY conf/php.ini /usr/local/etc/php/conf.d
COPY conf/project.pool.conf /usr/local/etc/php/pool.d/

#GD
RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev libxml2-dev && \
  docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
  NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
  docker-php-ext-install -j${NPROC} gd && \
  apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev


# Initial scripts

RUN apk add unzip zlib-dev chromium chromium-chromedriver
ENV PANTHER_NO_SANDBOX 1
ENV PANTHER_CHROME_DRIVER_BINARY /usr/lib/chromium/chromedriver

RUN apk add supervisor
COPY conf/supervisord.conf /etc/supervisord.conf

RUN apk add nodejs npm

RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted \
        gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN if [ -z `getent group www-data` ]; then addgroup -g ${GUID} www-data; fi
RUN if [ -z `getent passwd www-data` ]; then useradd -m -u ${UID} -g ${GUID} www-data; fi

RUN cp /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN mkdir -p /srv/var/logs /srv/var/cache

RUN chown -R www-data:www-data /srv/

RUN apk add --update busybox-suid

RUN mkdir /etc/periodic/everymin
COPY cron/orocron /etc/periodic/everymin
RUN chmod a+x /etc/periodic/everymin/orocron
RUN echo "*       *       *       *       *       run-parts /etc/periodic/everymin" >> /etc/crontabs/root
RUN apk add sudo
RUN echo "www-data ALL=(root) NOPASSWD:ALL" > /etc/sudoers.d/www-data && \
        chmod 0440 /etc/sudoers.d/www-data

USER www-data

RUN echo "alias ll='ls -l'" >> ~/.bashrc

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

EXPOSE 9000
