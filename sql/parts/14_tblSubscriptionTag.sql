#########################################################################################
# TABLE
# * This table deals with tag subscriptions.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_subscription_base
#########################################################################################
create table tbl_subscription_tag
(
	# Primary key
	id int auto_increment primary key,

	# Base implementation id
	id_base int not null,

	# Target tag
	id_tag int not null,

	foreign key (id_base)
		references tbl_subscription_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_tag)
		references tbl_tag(id)
		on update cascade
		on delete cascade
)$
#########################################################################################