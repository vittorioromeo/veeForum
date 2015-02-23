#########################################################################################
# TABLE
# * This table deals with log messages.
#########################################################################################
create table tbl_log
(
	# Primary key
	id int auto_increment primary key,

	# Log type
	type int not null default 0,

	# Entry timestamp
	creation_timestamp timestamp not null default 0,

	# Name
	value varchar(512) not null
)$
#########################################################################################