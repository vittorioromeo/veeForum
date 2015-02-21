#########################################################################################
# TABLE
# * This table deals with the many-to-many tag-content relationship.
#########################################################################################
create table tbl_tag_content
(
	# Primary key
	id int auto_increment primary key,

	# Tag
	id_tag int not null,

	# Content base
	id_content int not null,

	foreign key (id_tag)
		references tbl_tag(id)
		on update cascade
		on delete cascade,

	foreign key (id_content)
		references tbl_content_base(id)
		on update cascade
		on delete cascade
)$
#########################################################################################