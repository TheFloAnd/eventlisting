#!/bin/sh
apt-get update  # To get the latest package lists
apt-get upgrade -y
apt-get install apache2 -y
apt-get install mysql-common -y
apt-get install php -y
apt-get install git -y
apt-get install cron -y
cd /var/www/
git clone https://github.com/TheFloAnd/eventlisting.git  production
chmod -R 777 /var/www/production
rm -rf /var/www/html
mv -u /var/www/production/ /var/www/html/

systemctl enable cron.service
#write out current crontab
crontab -l > mycron
#echo new cron into cron file
echo "00 06 * * 1-5 git clone https://github.com/TheFloAnd/eventlisting.git  production" >> mycron
echo "@reboot firefox --kiosk http://localhost" >> mycron
#install new cron file
crontab mycron
rm -rf mycron


firefox --kiosk http://localhost