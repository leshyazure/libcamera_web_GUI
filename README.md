# PHP camera GUI
## Installation
- Install PHP, Apache and GIT:
```bash
sudo apt-get update && sudo apt-get install -y apache2 php git
```
- Clone repo
```bash
git clone https://github.com/leshyazure/libcamera_web_GUI.git
```
- Copy /src to /var/www/html
```bash
sudo rm -R * /var/www/html
cd libcamera_web_GUI/src/ && sudo cp * /var/www/html
```
- Remove asking for password using sudo
```bash
sudo nano /etc/sudoers
```
Find phrase:

%sudo   ALL=(ALL:ALL) ALL

And replace with:

%sudo   ALL=(ALL:ALL) NOPASSWD: ALL


- Restart server service
```bash
sudo service apache2 restart
```