#########################################################################################
# TABLE
# * This table deals with content shared data.
#########################################################################################
# HIERARCHY
# * Is base of: tbl_content_thread, tbl_content_post, 
#               tbl_content_attachment
#########################################################################################
create table tbl_content_base
(
	# Primary key
	id int auto_increment primary key,

	# Data
	creation_timestamp timestamp not null,
	id_author int not null,

	foreign key (id_author)
		references tbl_user(id)
		on update no action
		on delete no action
)$
#########################################################################################