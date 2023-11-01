FROM php:8.1.3-apache
ARG XDEBUG_VERSION="xdebug-3.2.2"
# Install dependencies
RUN apt-get update && apt-get install -y unzip \
    && rm -r /var/lib/apt/lists/*

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions gd mysqli pdo pdo_mysql

#RUN docker-php-ext-install mbstring exif pcntl bcmath  \
    #&& a2enmod headers \
    #&& sed -ri -e 's/^([ \t]*)(<\/VirtualHost>)/\1\tHeader set Access-Control-Allow-Origin "*"\n\1\2/g' /etc/apache2/sites-available/*.conf
#RUN docker-php-source delete

#RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY www/epayco /var/www/html

WORKDIR /var/www/html

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN service apache2 restart

#Xdebug
#RUN yes | pecl install ${XDEBUG_VERSION}
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY /php/dev/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#COPY config/php.ini /usr/local/etc/php/
COPY php/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY php/app.conf /etc/apache2/conf-enabled/z-app.conf
COPY php/app.ini $PHP_INI_DIR/conf.d/app.ini

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
RUN composer install --prefer-dist --no-progress --no-suggest --no-ansi --no-interaction
RUN a2enmod headers rewrite
# Clear cache
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN composer install
#RUN a2enmod rewrite