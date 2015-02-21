#########################################################################################
# TABLE
# * This table deals with attachments, a type of content.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_content_base
#########################################################################################
create table tbl_content_attachment
(
	# Primary key
	id int auto_increment primary key,

	# Creation data
	id_base int not null,

	# Parent post
	id_post int not null,

	# File data
	id_file_data int not null,

	foreign key (id_base)
		references tbl_content_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_post)
		references tbl_content_post(id)
		on update no action
		on delete no action,

	foreign key (id_file_data)
		references tbl_file_data(id)
		on update no action
		on delete no action
)$
#########################################################################################
