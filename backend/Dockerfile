FROM php:8.3-fpm AS backend

WORKDIR /usr/src

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    git \
    curl \
    zip \
    unzip \
    supervisor \
    default-mysql-client

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN pecl install redis

COPY --from=composer:2.8.1 /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /usr/src

COPY ./backend .

RUN composer install

COPY ./deployment/config/php-fpm/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./deployment/config/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

USER $user

FROM backend AS worker
CMD [ "/bin/sh", "-c", "nice -n 10 php /usr/src/artisan queue:work --tries=3 --verbose --timeout=30 --sleep=3 --rest=1 --max-jobs=1000 --max-time=3600" ]

FROM backend AS scheduler
CMD [ "/bin/sh", "-c", "nice -n 10 sleep 69 && php /usr/src/artisan schedule:run --verbose --no-interaction" ]
