#!/bin/bash

MYSQL_PASSWORD="symfony2"

# update
apt-get update
# set mysql password
debconf-set-selections <<< "mysql-server mysql-server/root_password password ${MYSQL_PASSWORD}"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password ${MYSQL_PASSWORD}"
# install dependencies
apt-get install -y \
    php5 \
    php5-cli \
    php5-curl \
    php5-gd \
    php5-memcached \
    php5-imagick \
    php5-imap \
    php5-mysql \
    php5-json \
    php5-xsl \
    php5-mcrypt \
    php5-intl \
    php5-xcache \
    php5-mongo \
    libssh2-php \
    php5-mcrypt \
    php5-intl \
    git \
    mysql-server \
    apache2 \
    libapache2-mod-php5

#enable mod_rewrite
a2enmod rewrite
# configure
cat <<< EOT > /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/notifair/web
    <Directory /var/www/notifair/web>
        # enable the .htaccess rewrites
        AllowOverride All
        Order allow,deny
        Allow from All
        </Directory>
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOT
# restart apache
service apache2 restart

# prepare mysql database
echo "CREATE DATABASE symfony2 CHARACTER SET utf8 COLLATE utf8_general_ci;" | mysql -u root -p$MYSQL_PASSWORD

# install composer globally
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
