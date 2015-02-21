#########################################################################################
# PROCEDURE
# * Return the subscriptor ID from a subscription base ID.
#########################################################################################
create procedure get_subscriptor
(
	in v_id_base int,
	out v_id_subscriptor int
)
begin
	select id_subscriptor
	into v_id_subscriptor
	from tbl_subscription_base
	where id = v_id_base;
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Returns true if an unseen notification user with a specific 
#   subscriptor ID and a specific user ID exists.
#########################################################################################
create procedure check_notification_unseen_existance_user
(
	in v_id_subscriptor int,
	in v_id_user int,
	out v_result boolean
)
begin
	set v_result := exists
	(
		select tb.id_receiver, tb.seen, ts.id_user
		from tbl_notification_base as tb
			inner join tbl_notification_user as td on tb.id = td.id_base
			inner join tbl_subscription_user as ts on td.id_subscription_user = ts.id
		where
			tb.seen = false
			and tb.id_receiver = v_id_subscriptor
			and ts.id_user = v_id_user
	);
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Returns true if an unseen notification thread with a specific 
#   subscriptor ID and a specific thread ID exists.
#########################################################################################
create procedure check_notification_unseen_existance_thread
(
	in v_id_subscriptor int,
	in v_id_thread int,
	out v_result boolean
)
begin
	set v_result := exists
	(
		select tb.id_receiver, tb.seen, ts.id_thread
		from tbl_notification_base as tb
			inner join tbl_notification_thread as td on tb.id = td.id_base
			inner join tbl_subscription_thread as ts on td.id_subscription_thread = ts.id
		where
			tb.seen = false
			and tb.id_receiver = v_id_subscriptor
			and ts.id_thread = v_id_thread
	);
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Returns true if an unseen notification user with a specific 
#   subscriptor ID and a specific tag ID exists.
#########################################################################################
create procedure check_notification_unseen_existance_tag
(
	in v_id_subscriptor int,
	in v_id_tag int,
	out v_result boolean
)
begin
	set v_result := exists
	(
		select tb.id_receiver, tb.seen, ts.id_tag
		from tbl_notification_base as tb
			inner join tbl_notification_tag as td on tb.id = td.id_base
			inner join tbl_subscription_tag as ts on td.id_subscription_tag = ts.id
		where
			tb.seen = false
			and tb.id_receiver = v_id_subscriptor
			and ts.id_user = v_id_tag
	);
end$
#########################################################################################