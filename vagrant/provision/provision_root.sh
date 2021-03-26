#!/bin/bash

yum update -y
yum -y install zip unzip
yum install -y wget

# apacheのインストール
yum install -y httpd

#phpのリポジトリの追加
yum -y install epel-release && \
yum -y install http://rpms.famillecollet.com/enterprise/remi-release-7.rpm && \

#php7.4のインストール
yum -y install --enablerepo=remi,remi-php74 php php-devel php-mbstring php-pdo php-gd php-xml php-mcrypt php-mysqlnd php-pecl-xdebug php-pecl-zip php-tokenizer php-fpm&& \

#composerのインストール
curl -s https://getcomposer.org/installer | php && \
mv composer.phar /usr/local/bin/composer && \

# imagemagickのインストール
# yum -y install --enablerepo=remi ImageMagick-last && \
yum -y install --enablerepo=epel,remi ImageMagick && \

#PHP用imagemagickモジュールをインストール
yum -y install --enablerepo=remi-php74 php-pecl-imagick && \

#帳票フォントインストール
yum -y install ipa-gothic-fonts ipa-pgothic-fonts && \

#MySQLのインストール
rpm -ivh https://dev.mysql.com/get/mysql80-community-release-el7-2.noarch.rpm && \
yum -y install mysql-community-server

#node.jsのインストール
curl -sL https://rpm.nodesource.com/setup_12.x | bash -
yum install -y nodejs

# ライブラリインストール
sudo yum -y update
sudo yum -y install vim-enhanced

#設定ファイルのコピー
cp /vagrant/provision/php-fpm/www.conf /etc/php-fpm.d/
cp /vagrant/provision/mysql/my.cnf /etc/
cp /vagrant/provision/php/php.ini /etc/
cp /vagrant/provision/apache/httpd.conf /etc/httpd/conf/
cp /usr/share/zoneinfo/Japan /etc/localtime

# SELinuxの設定
setenforce 0

#自動起動設定
systemctl enable mysqld
systemctl enable httpd.service
systemctl enable php-fpm

#サービス停止（初回時は停止しているが、provision時を想定）
systemctl stop mysqld
systemctl stop httpd.service
systemctl stop php-fpm

#サービス起動
systemctl start mysqld
systemctl restart httpd.service
systemctl start php-fpm

# Apache起動確認
service httpd status

#npm install
cd /var/www/html
npm install
