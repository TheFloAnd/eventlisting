#!/bin/sh
sudo apt update  # To get the latest package lists
sudo apt upgrade -y
sudo apt install apache2 mysql-common php git cron -y
cd /var/www/
git clone https://github.com/TheFloAnd/eventlisting.git  production
sudo chmod -R 777 /var/www/production
sudo rm -rf /var/www/html
sudo mv -u /var/www/production/ /var/www/html/

sudo systemctl enable cron.service
#write out current crontab
sudo crontab -l > mycron
#echo new cron into cron file
sudo echo "00 06 * * 1-5 git pull https://github.com/TheFloAnd/eventlisting.git  production" >> mycron
sudo echo "00 06 * * 1-5 sudo apt update && sudo apt upgrade -y && sudo apt autoremove -y" >> mycron
sudo echo "@reboot chromium-browser --kiosk http://localhost" >> mycron
sudo echo "@reboot firefox --kiosk http://localhost" >> mycron
#install new cron file

sudo crontab mycron
sudo rm -rf mycron

sudo apt autoremove -y

sudo reboot