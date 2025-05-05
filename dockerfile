# Usar imagem base com PHP 8.1 + Apache
FROM php:8.1-apache

# Instalar dependências do sistema e extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libicu-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev libonig-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install intl gd pdo pdo_mysql mbstring zip exif && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli


    # Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Ativar mod_rewrite do Apache
RUN a2enmod rewrite

# Criar storage com permissões e definir diretório de trabalho
RUN mkdir -p /var/www/html && chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Copiar arquivos do projeto
COPY . /var/www/html

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Configurar o Apache para usar o diretório public do CodeIgniter
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Definir diretório de trabalho correto
WORKDIR /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
