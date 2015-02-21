#########################################################################################
# Copyright (c) 2013-2015 Vittorio Romeo
# License: Academic Free License ("AFL") v. 3.0
# AFL License page: http://opensource.org/licenses/AFL-3.0
#########################################################################################
# http://vittorioromeo.info
# vittorio.romeo@outlook.com
#########################################################################################

#########################################################################################
# veeForum forum framework initialization and creation script
#########################################################################################

#########################################################################################
# This script is meant to be run once to create and initialize
# from scratch the whole MySQL veeForum backend.
# Therefore, we drop the database if exists and re-create it.
drop database if exists db_forum_new$
create database db_forum_new$
use db_forum_new$
#########################################################################################
