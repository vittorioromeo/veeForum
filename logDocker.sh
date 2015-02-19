#!/bin/bash

docker exec $(docker ps -a -q) cat /var/log/httpd/error_log
