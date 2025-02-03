#!/bin/bash

sudo apt update
sudo apt upgrade -y

# Install apache2 and php
sudo apt install -y apache2
sudo apt install -y php libapache2-mod-php
# Start Apache2
sudo systemctl start apache2
# Make it start at boot
sudo systemctl enable apache2


# Install MariaDB
sudo apt install -y mariadb-server
# Start MariaDB
sudo systemctl start mariadb
# Make it start at boot
sudo systemctl enable mariadb

# Secure installation script for mysql / mariadb
sudo mysql_secure_installation
# DB deploy
bash deploy_mysql.sh

sudo cp -r ../vulnerable_website/* /var/www/html/
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/

sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw reload


