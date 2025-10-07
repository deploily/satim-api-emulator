FROM mcr.microsoft.com/devcontainers/php:1-8.2-bookworm

# Install dependencies + PHP extensions
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client libicu-dev libzip-dev libpng-dev libonig-dev libzip-dev libxml2-dev libicu-dev zip unzip git curl\ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql zip mbstring exif pcntl bcmath gd intl


#RUN pecl install xdebug && docker-php-ext-enable xdebug

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1
