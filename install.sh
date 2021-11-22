#!/bin/sh
sudo apt-get update  # To get the latest package lists
sudo apt-get upgrade -y
sudo apt-get install apache2 -y
sudo apt-get install mysql-common -y
sudo apt-get install php -y
sudo apt-get install git -y
sudo apt-get install cron -y
cd /var/www/
git clone https://github.com/TheFloAnd/eventlisting.git  production
sudo chmod -R 777 /var/www/production
sudo rm -rf /var/www/html
sudo mv -u /var/www/production/ /var/www/html/

sudo systemctl enable cron.service
#write out current crontab
sudo crontab -l > mycron
#echo new cron into cron file
sudo echo "00 06 * * 1-5 git clone https://github.com/TheFloAnd/eventlisting.git  production" >> mycron
# echo "@reboot firefox --kiosk http://localhost" >> mycron
# echo "@reboot chromium-browser --kiosk http://localhost" >> mycron
#install new cron file


# xdg-open http://localhost
if chromium-browser --kiosk http://localhost
then
    sudo echo "@reboot chromium-browser --kiosk http://localhost" >> mycron
else
    if firefox --kiosk http://localhost
    then
        sudo echo "@reboot firefox --kiosk http://localhost" >> mycron
    else
        sudo echo "@reboot xdg-open http://localhost" >> mycron
        sudo echo "@reboot xdotool key F11" >> mycron
        sudo apt-get install xdotool -y
        xdg-open http://localhost
        xdotool key F11
    fi
fi

sudo crontab mycron
sudo rm -rf mycron

sudo reboot