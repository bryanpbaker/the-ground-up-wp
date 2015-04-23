
while true
do
  [ -f /vagrant/Vagrantfile ] && break
  sleep 0.1
done
rm -f /etc/nginx/nginx.conf
rm -f /etc/mysql/my.cnf
rm -f /etc/php5/fpm/php-fpm.conf
rm -f /etc/php5/fpm/php.ini
cp -f /vagrant/vagrant-config/my.cnf /etc/mysql/my.cnf
cp -f /vagrant/vagrant-config/nginx.conf /etc/nginx/nginx.conf
cp -f /vagrant/vagrant-config/php-fpm.conf /etc/php5/fpm/php-fpm.conf
cp -f /vagrant/vagrant-config/php.ini /etc/php5/fpm/php.ini
service mysql restart
mysql -uroot -proot < /vagrant/vagrant-config/reset.sql
mysql -uroot -proot safeway_wp < /vagrant/vagrant-config/schema.sql
service nginx restart
service php5-fpm restart
