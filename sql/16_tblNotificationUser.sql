#########################################################################################
# TABLE
# * This table deals with user notifications.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_notification_base
#########################################################################################
create table tbl_notification_user
(
	# Primary key
	id int auto_increment primary key,

	# Base
	id_base int not null,

	# Subscription
	id_subscription_user int not null,

	foreign key (id_base)
		references tbl_notification_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_subscription_user)
		references tbl_subscription_user(id)
		on update cascade
		on delete cascade
)$
#########################################################################################