#########################################################################################
# TABLE
# * This table deals with posts, a type of content.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_content_base
#########################################################################################
create table tbl_content_post
(
	# Primary key
	id int auto_increment primary key,

	# Creation data
	id_base int not null,

	# Parent thread
	id_thread int not null,

	# Data
	contents text not null,

	foreign key (id_base)
		references tbl_content_base(id)
		on update cascade
		on delete no action,

	foreign key (id_thread)
		references tbl_content_thread(id)
		on update no action
		on delete no action
)$
#########################################################################################