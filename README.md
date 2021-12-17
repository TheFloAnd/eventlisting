# Auflistung von Events

## Features

* automatic refresh
* Shows events of the day
* Shows future events
    * Set future day range
* Add, Edit and Disable Groups
    * Change Group color
* Add, Edit and Delete Events
    * Add returning Events
    * Delete in the Future returning Events
* Automatic Refresh
    * Set/change refresh time


## Install
```
bash <(curl -sL https://raw.githubusercontent.com/TheFloAnd/eventlisting/production/install.sh)
```
#### OR
```
bash <(wget -nv -O - https://raw.githubusercontent.com/TheFloAnd/eventlisting/production/install.sh)
```
### Alternative Autostart
```
> sudo apt-get install x11-xserver-utils unclutter
```
```
> cp /etc/xdg/lxsession/LXDE-pi/autostart ~/.config/lxsession/LXDE-pi/
```
```
> nano ~/.config/lxsession/LXDE-pi/autostart
```
```
> @xset s noblank <br>
> @xset s off <br>
> @xset -dpms <br>
> @unclutter -idle 0.1 -roo <br>
> /usr/bin/chromium-browser --kiosk --start {DOMAIN/IP}
```
