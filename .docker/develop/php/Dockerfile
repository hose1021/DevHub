FROM php:8-cli-alpine

RUN apk update && apk add --no-cache \
    zip \
    libzip-dev \
    mysql-client \
    pcre-dev ${PHPIZE_DEPS} \
    make \
    shadow \
    bash \
    tzdata \
    nano \
    supervisor \
    nodejs npm \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install sockets \
    && docker-php-ext-install zip pdo_mysql exif opcache pcntl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quit \
    && npm --global install yarn \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

ENV TZ=Asia/Baku

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

#COPY ./.docker/develop/php/local.ini $PHP_INI_DIR/conf.d
#COPY ./.docker/develop/php/xlaravel.pool.conf /usr/local/etc/php-fpm.d/
RUN docker-php-ext-install sockets

COPY ./.docker/develop/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

ENTRYPOINT ["supervisord", "--nodaemon", "--configuration", "/etc/supervisor/conf.d/supervisord.conf"]

#TODO: add cron
#COPY ./.docker/common/crontab /etc/crontabs/root
#CMD crond -f
