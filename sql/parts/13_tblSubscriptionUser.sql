#########################################################################################
# TABLE
# * This table deals with user subscriptions.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_subscription_base
#########################################################################################
create table tbl_subscription_user
(
	# Primary key
	id int auto_increment primary key,

	# Base implementation id
	id_base int not null,

	# Target user
	id_user int not null,

	foreign key (id_base)
		references tbl_subscription_base(id)
		on update cascade
		on delete cascade, # TODO: use a trigger

	foreign key (id_user)
		references tbl_user(id)
		on update cascade
		on delete no action # Triggers do not get fired with 'cascade'
)$
#########################################################################################