#!/bin/sh
echo "copying files"
sudo cp -r ../OnlineFiles /var/www
sudo chmod 755 ~/.profile
sudo chmod 777 /etc/apache2/sites-enabled/000-default.conf


echo "adding files to path"
sudo echo 'PATH="$PATH:/var/www/OnlineFiles/bin"' >> ~/.profile
echo "Adding data to apache"
echo "Listen 25500" >> /etc/apache2/sites-enabled/000-default.conf
echo "<VirtualHost *:25500>" >> /etc/apache2/sites-enabled/000-default.conf
echo "	ServerAdmin webmaster@localhost" >> /etc/apache2/sites-enabled/000-default.conf
echo "	DocumentRoot /var/www/OnlineFiles" >> /etc/apache2/sites-enabled/000-default.conf
echo "	ErrorLog ${APACHE_LOG_DIR}/error.log" >> /etc/apache2/sites-enabled/000-default.conf
echo "	CustomLog ${APACHE_LOG_DIR}/access.log combined" >> /etc/apache2/sites-enabled/000-default.conf
echo "</VirtualHost>" >> /etc/apache2/sites-enabled/000-default.conf
sudo service apache2 restart
echo "changing permissions"
sudo chown -R $USER:$USER /var/www/OnlineFiles
find /var/www/OnlineFiles -type d -exec chmod 777 {} \;
chmod a+x /var/www/OnlineFiles/bin/*
echo "Finished installation"

