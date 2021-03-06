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
### Repo

#### curl
```
bash <(curl -sL https://raw.githubusercontent.com/TheFloAnd/eventlisting/production/install.sh)
```
#### wget
```
bash <(wget -nv -O - https://raw.githubusercontent.com/TheFloAnd/eventlisting/production/install.sh)
```
### Gist
#### curl
```
bash <(curl -sL https://gist.githubusercontent.com/TheFloAnd/b73c5bfbffc5acb649b02fd62968e33e/raw/704f9781a02ca471cf5112036fea5eed44bc3808/Eventlisting-install.sh)
```
#### wget
```
bash <(wget -nv -O - https://gist.githubusercontent.com/TheFloAnd/b73c5bfbffc5acb649b02fd62968e33e/raw/704f9781a02ca471cf5112036fea5eed44bc3808/Eventlisting-install.sh)
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
