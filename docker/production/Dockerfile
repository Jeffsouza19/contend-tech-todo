FROM webdevops/php-nginx:8.4-alpine

ENV WEB_DOCUMENT_ROOT=/app/public

ENV PHP_DISMOD=bz2,calendar,exiif,ffi,intl,gettext,ldap,mysqli,imap,soap,sockets,sysvshm,sysvsm,sysvmsg,shmop,xsl,zip,gd,apcu,vips,yaml,imagick,amqp,sqlite

WORKDIR /app

COPY . .

RUN composer install --no-dev --no-interaction --prefer-dist

COPY docker/production/start-container /usr/local/bin

RUN chmod +x /usr/local/bin/start-container

RUN chown -R application:application .

ENTRYPOINT [ "start-container" ]
