#########################################################################################
# TABLE
# * This table deals with subscription shared data.
# * Subscriptions allow users to track content or other users.
#########################################################################################
# HIERARCHY
# * Is base of: tbl_subscription_thread, tbl_subscription_tag, 
#               tbl_subscription_user
#########################################################################################
create table tbl_subscription_base
(
	# Primary key
	id int auto_increment primary key,

	# Subscriptor user
	id_subscriptor int not null,

	# Timestamp of beginning
	creation_timestamp timestamp not null default 0,

	# Active/inactive
	active boolean not null default true,

	foreign key (id_subscriptor)
		references tbl_user(id)
		on update cascade
		on delete cascade
)$
#########################################################################################
