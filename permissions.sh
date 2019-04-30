sudo usermod -a -G www-data guilherme_fabrin
sudo chown -R guilherme_fabrin:www-data $PWD
sudo find $PWD -type f -exec chmod 664 {} \;
sudo find $PWD -type d -exec chmod 775 {} \;
sudo chgrp -R www-data storage $PWD/bootstrap/cache
sudo chmod -R ug+rwx storage $PWD/bootstrap/cache
