#!/bin/bash

# SELinuxの設定
setenforce 0

#サービス起動
systemctl start mysqld
systemctl restart httpd.service
systemctl start php-fpm
