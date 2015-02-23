#########################################################################################
# TABLE
# * This table deals with notification shared data.
# * Notifications are created when users need to be notified
#   about content they are subscribed to.
#########################################################################################
# HIERARCHY
# * Is base of: tbl_notification_user, tbl_notification_thread, 
#               tbl_notification_tag
#########################################################################################
create table tbl_notification_base
(
	# Primary key
	id int auto_increment primary key,

	# Receiver of the notification
	id_receiver int not null,

	# Notification seen?
	seen boolean not null default false,

	# Notification data creation timestamp
	creation_timestamp timestamp not null default 0,

	foreign key (id_receiver)
		references tbl_user(id)
		on update cascade
		on delete cascade
)$
#########################################################################################
