#!/bin/bash

# Mise à jour et upgrade du système
sudo dnf update
sudo dnf upgrade -y

# Installation d'Apache (httpd) et PHP
sudo dnf install -y httpd php php-mysqlnd

# Installation de ufw (pare-feu)
sudo dnf install ufw

# Ajout de l'utilisateur www-data (si nécessaire)
sudo useradd -r -s /usr/sbin/nologin www-data

# Démarrage du service httpd (Apache)
sudo systemctl start httpd

# Activation du démarrage automatique d'Apache au boot
sudo systemctl enable httpd

# Installation de MariaDB
sudo dnf install -y mariadb-server

# Démarrage du service MariaDB
sudo systemctl start mariadb

# Activation du démarrage automatique de MariaDB au boot
sudo systemctl enable mariadb

# Exécution du script de sécurisation de MariaDB
sudo mysql_secure_installation

# Déploiement de la base de données
bash deploy_mysql.sh

# Copie du site web vulnérable dans le répertoire d'Apache
sudo cp -r ../vulnerable_website/* /var/www/html/

# Modification des droits d'accès pour les fichiers du site
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/

# Ouverture des ports HTTP et HTTPS dans le pare-feu
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw reload

