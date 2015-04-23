ln -sf /usr/share/zoneinfo/America/Chicago /etc/localtime
apt-get update
apt-get -y install python-software-properties
apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
sudo add-apt-repository ppa:ondrej/php5
apt-get update
echo "mysql-server mysql-server/root_password select root" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again select root" | debconf-set-selections
echo "mysql-server mysql-server/root_password password root" | debconf-set-selections
echo "mysql-server mysql-server/root_password_again password root" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password select root" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password_again select root" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password password root" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password_again password root" | debconf-set-selections
echo "mysql-server-5.6 mysql-server/root_password select root" | debconf-set-selections
echo "mysql-server-5.6 mysql-server/root_password_again select root" | debconf-set-selections
echo "mysql-server-5.6 mysql-server/root_password password root" | debconf-set-selections
echo "mysql-server-5.6 mysql-server/root_password_again password root" | debconf-set-selections
apt-get -y install git multitail nginx libcurl3-dev linux-headers-$(uname -r) build-essential php5 php5-fpm php5-gd php5-curl php5-mysql mysql-server
echo "
check_mail:0" >> /etc/multitail.conf
mysql -uroot -proot < /vagrant/vagrant-config/users.sql
chown -R vagrant:vagrant /home/vagrant/
