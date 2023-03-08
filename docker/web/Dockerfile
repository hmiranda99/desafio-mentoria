FROM php:8.1-fpm-alpine

## Definindo o diretório principal
WORKDIR /var/www/html/

## Dando o poder de acessar ao usuário master
USER root
 
RUN apk update && \ 
    ## add: para instalar pacotes | -no-cache: para que não venha com cache | util-linux: para aceitar comandos linux
    apk add --no-cache util-linux \
    ## bash: interpretador de comandos (shell)
    bash \
    git \
    ## curl: ferramenta para transferir dados de/para um servidor (HTTP) (postman)
    curl \
    ## vim: editor de textos
    vim \
    ## nano: editor de textos
    nano \
    ## php7-phpdbg: voltado para identificar e remover qualquer tipo de erro existente no código-fonte de um programa
    php7-phpdbg \
    supervisor \
    nodejs \
    npm \
    sudo

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \ 
    && apk add --update linux-headers \
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps \
    && docker-php-ext-install mysqli pdo pdo_mysql bcmath sockets pcntl

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/php.ini-development
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/php.ini-development
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/php.ini-production
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/php.ini-production

# Docker non-root-user
## definindo variáveis de ambiente
## ARG definindo o valor no momento da construção da imagem
## ENV recebendo o valor em tempo de execução
ARG PUID=1000
ENV PUID 1000
ARG PGID=1000
ENV PGID 1000

RUN addgroup -g ${PGID} docker && \
    adduser -D -u ${PUID} -G docker docker 

# Composer install
USER root

RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer

RUN . ~/.bashrc

# Clean Up 
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog \
    rm -rf /var/cache/apk/*

RUN chown root:root .

# nodejs
#RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - && \
#    apk add nodejs

#ENV NODE_VERSION=18.14.2
#RUN apt install -y curl
#RUN curl -sL https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
#ENV NVM_DIR=/root/.nvm
#RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
#RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
#RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
#ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
#RUN node --version
#RUN npm --version


COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 9000 and start php-fpm server
CMD ["php-fpm"]
#CMD ["php-fpm", "npm start"]
#CMD ["php-fpm"]

EXPOSE 9000