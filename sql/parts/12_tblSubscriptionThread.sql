#########################################################################################
# TABLE
# * This table deals with thread subscriptions.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_subscription_base
#########################################################################################
create table tbl_subscription_thread
(
	# Primary key
	id int auto_increment primary key,

	# Base implementation id
	id_base int not null,

	# Target thread
	id_thread int not null,

	foreign key (id_base)
		references tbl_subscription_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_thread)
		references tbl_content_thread(id)
		on update cascade
		on delete cascade
)$
#########################################################################################
