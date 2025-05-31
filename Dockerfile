FROM wordpress:php7.4

RUN apt-get update && \
      apt-get -y install sudo

RUN apt-get update && apt-get install -y

RUN apt-get update && apt-get install less

RUN apt-get install -y curl

RUN apt-get install -y vim

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && php wp-cli.phar --info && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -\
  && apt-get install -y nodejs

ENV WP_DIR /var/www/html
WORKDIR $WP_DIR
ADD . .

RUN cd $WP_DIR/wp-content/themes/pibusiness && composer install --no-dev --no-interaction -o
RUN npm install -g webpack webpack-cli
RUN cd $WP_DIR/wp-content/themes/pibusiness && rm -rf node_modules && npm install