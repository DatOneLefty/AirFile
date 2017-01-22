#!/bin/sh
echo "copying files"
sudo cp ../OnlineFiles /var
sudo chmod 755 ~/.profile
sudo chmod 755 /etc/apache/sites-enabled/000-default.conf


echo "adding files to path"
sudo echo "export PATH=$PATH:/var/OnlineFiles/bin" >> ~/.profile
echo "Adding data to apache"
echo "Listen 25500" >> /etc/apache2/sites-enabled/000-default.conf
echo "<VirtualHost *:25500>" >> /etc/apache2/sites-enabled/000-default.conf
echo "	ServerAdmin webmaster@localhost" >> /etc/apache2/sites-enabled/000-default.conf
echo "	DocumentRoot /var/OnlineFiles" >> /etc/apache2/sites-enabled/000-default.conf
echo "	ErrorLog ${APACHE_LOG_DIR}/error.log" >> /etc/apache2/sites-enabled/000-default.conf
echo "	CustomLog ${APACHE_LOG_DIR}/access.log combined" >> /etc/apache2/sites-enabled/000-default.conf
echo "</VirtualHost>" >> /etc/apache2/sites-enabled/000-default.conf
sudo service apache2 restart
echo "Finished installation"
