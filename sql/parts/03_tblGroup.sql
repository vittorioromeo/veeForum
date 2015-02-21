#########################################################################################
# TABLE
# * This table deals with groups.
# * Every group row also contains its forum-wide privileges.
#########################################################################################
create table tbl_group
(
	# Primary key
	id int auto_increment primary key,

	# Parent group (null is allowed)
	id_parent int,

	# Name,
	name varchar(255) not null,

	# Privs
	is_superadmin boolean not null default false,
	can_manage_sections boolean not null default false,
	can_manage_users boolean not null default false,
	can_manage_groups boolean not null default false,
	can_manage_permissions boolean not null default false,

	foreign key (id_parent)
		references tbl_group(id)
		on update cascade
		on delete cascade
)$
#########################################################################################