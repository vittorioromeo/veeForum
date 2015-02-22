#########################################################################################
# TABLE
# * This table deals with tag notifications.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_notification_base
#########################################################################################
create table tbl_notification_tag
(
	# Primary key
	id int auto_increment primary key,

	# Base
	id_base int not null,

	# Subscription
	id_subscription_tag int not null,

	foreign key (id_base)
		references tbl_notification_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_subscription_tag)
		references tbl_subscription_tag(id)
		on update cascade
		on delete no action # Triggers do not get fired with 'cascade'
)$
#########################################################################################