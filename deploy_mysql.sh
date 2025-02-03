#!/bin/bash

DB_NAME="site_web"
DB_USER="admin"
DB_PASS="SuperSecurePassword"
SQL_SCRIPT="setup.sql"

echo "Déploiement de MySQL en cours..."

# Installation de MySQL/MariaDB si ce n'est pas déjà installé
if ! command -v mysql &> /dev/null; then
    echo "🔍 Installation de MariaDB..."
    sudo apt update && sudo apt install -y mariadb-server
else
    echo "MariaDB est déjà installé."
fi

# Démarrage du service MySQL
echo "Démarrage du service MySQL..."
sudo systemctl start mariadb
sudo systemctl enable mariadb

# Création du fichier SQL
cat <<EOF > $SQL_SCRIPT
CREATE DATABASE IF NOT EXISTS $DB_NAME;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';

USE site_web;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255),
    description TEXT
);

FLUSH PRIVILEGES;
EOF

# Exécution du script SQL
echo "Configuration de la base de données..."
sudo mysql -u root < $SQL_SCRIPT

# Nettoyage
rm -f $SQL_SCRIPT

echo "Déploiement terminé !"
echo "Connexion à MySQL : mysql -u $DB_USER -p$DB_PASS $DB_NAME"

