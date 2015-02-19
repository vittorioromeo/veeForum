#!/bin/bash

myDir=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
root=$(realpath $myDir/../../www/)

sudo chmod -R 770 $root
sudo chgrp -R 33 $root

sudo docker run -t -i -v $root:/srv/http --name forum -p 80:80 -p 443:443 -d superv1234/forum /bin/bash -c "cd '/usr'; sudo /usr/bin/mysqld_safe --datadir='/var/lib/mysql'& sudo apachectl -DFOREGROUND"