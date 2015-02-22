#########################################################################################
# TABLE
# * This table deals with threads, a type of content.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_content_base
#########################################################################################
create table tbl_content_thread
(
	# Primary key
	id int auto_increment primary key,

	# Content base
	id_base int not null,

	# Parent section
	id_section int not null,

	# Data
	title varchar(255) not null,

	foreign key (id_base)
		references tbl_content_base(id)
		on update cascade
		on delete no action,

	foreign key (id_section)
		references tbl_section(id)
		on update no action
		on delete no action
)$
#########################################################################################
