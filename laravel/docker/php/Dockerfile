FROM php:7.2-fpm
COPY conf/php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y zlib1g-dev default-mysql-client \
  && docker-php-ext-install zip pdo_mysql

#Composer install
# RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# RUN php composer-setup.php
# RUN php -r "unlink('composer-setup.php');"
# RUN mv composer.phar /usr/local/bin/composer

# ENV COMPOSER_ALLOW_SUPERUSER 1
# ENV COMPOSER_HOME /composer
# ENV PATH $PATH:/composer/vendor/bin

WORKDIR /var/www

# ユーザーを追加
# ENV USER_NAME=app
# RUN groupadd -g ${GID} ${USER_NAME}
# RUN useradd -g ${GID} -u ${UID} ${USER_NAME}
# RUN usermod -aG www-data ${USER_NAME}

ENV UID=1000
ENV GID=1000
RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

# RUN composer create-project --prefer-dist laravel/laravel laravel

RUN chown -R www-data:www-data /var/www

