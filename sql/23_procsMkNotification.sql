#########################################################################################
# PROCEDURE
# * Create a notification base and return its ID.
#########################################################################################
create procedure mk_notification_base
(
	in v_id_receiver int,
	out v_created_id int
)
begin
	insert into tbl_notification_base
		(id_receiver, seen, creation_timestamp)
		values(v_id_receiver, false, now());

	set v_created_id := LAST_INSERT_ID();
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a notification base + notification user.
#########################################################################################
create procedure mk_notification_user
(
	in v_id_receiver int,
	in v_id_subscription_user int
)
begin
	call mk_notification_base(v_id_receiver, @out_id_base);

	insert into tbl_notification_user
		(id_base, id_subscription_user)
		values(@out_id_base, v_id_subscription_user);
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a notification base + notification thread.
#########################################################################################
create procedure mk_notification_thread
(
	in v_id_receiver int,
	in v_id_subscription_thread int
)
begin
	call mk_notification_base(v_id_receiver, @out_id_base);

	insert into tbl_notification_thread
		(id_base, id_subscription_thread)
		values(@out_id_base, v_id_subscription_thread);
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a notification base + notification tag.
#########################################################################################
create procedure mk_notification_tag
(
	in v_id_receiver int,
	in v_id_subscription_tag int
)
begin
	call mk_notification_base(v_id_receiver, @out_id_base);

	insert into tbl_notification_tag
		(id_base, id_subscription_tag)
		values(@out_id_base, v_id_subscription_tag);
end$
#########################################################################################