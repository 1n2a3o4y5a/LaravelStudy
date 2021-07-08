FROM php:7.3-apache
RUN docker-php-ext-install pdo_mysql
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g