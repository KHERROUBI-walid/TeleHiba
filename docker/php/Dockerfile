# Utiliser une image officielle PHP 8.3 avec FPM
FROM php:8.3-fpm

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install intl pdo_mysql pcntl zip opcache mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer Redis extension PHP
RUN pecl install redis && docker-php-ext-enable redis

# Installer Xdebug (pour debug local)
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Créer un utilisateur symfony
RUN groupadd -g 1000 symfony \
    && useradd -u 1000 -m -g symfony symfony

# Changer d'utilisateur après toutes les opérations root
USER symfony

# Configurer git (en tant que symfony)
RUN git config --global user.email "khe.walid78@gmail.com"
RUN git config --global user.name "walid"

# Définir le répertoire de travail
WORKDIR /var/www/html

# Variables d'environnement
ENV APP_ENV=dev
ENV COMPOSER_ALLOW_SUPERUSER=1


# Exposer le port FPM
EXPOSE 9000