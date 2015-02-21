#########################################################################################
# TABLE
# * This table deals with sections.
#########################################################################################
create table tbl_section
(
	# Primary key
	id int auto_increment primary key,

	# Parent section (null is allowed)
	id_parent int,

	# Data
	name varchar(255) not null,

	foreign key (id_parent)
		references tbl_section(id)
		on update no action
		on delete no action
)$
#########################################################################################