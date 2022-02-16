# ISPConfig - Bitbucket Install

Apache Directives (ISPConfig)
DocumentRoot "{DOCROOT_CLIENT}/public"

```sh
cd /var/www/site/private
sudo -u web135 ssh-keygen (copy .ssh/id_rsa.pub to Bitbucket settings)
sudo -u web135 git clone git@bitbucket.org:xxx/yyy.git .
sudo -u web135 cp .env.example .env
sudo -u web135 composer install
php artisan key:generate
sudo chmod -R 777 storage

sudo -u web135 ln -s /var/www/site/private/public/ /var/www/site/web/
php artisan migrate:fresh
```
