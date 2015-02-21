#########################################################################################
# TABLE
# * This table deals with binary file data.
# * Used for attachments.
#########################################################################################
create table tbl_file_data
(
	# Primary key
	id int auto_increment primary key,

	# Data
	filename varchar(255) not null,
	data blob not null
)$
#########################################################################################