#########################################################################################
# PROCEDURE
# * Create a subscription base and return its ID.
#########################################################################################
create procedure mk_subscription_base
(
	in v_id_subscriptor int,
	out v_created_id int
)
begin
	insert into tbl_subscription_base
		(id_subscriptor, creation_timestamp, active)
		values(v_id_subscriptor, now(), true);

	set v_created_id := LAST_INSERT_ID();
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a subscription base + subscription user.
#########################################################################################
create procedure mk_subscription_user
(
	in v_id_subscriptor int,
	in v_id_user int
)
begin
	call mk_subscription_base(v_id_subscriptor, @out_id_base);

	insert into tbl_subscription_user
		(id_base, id_user)
		values(@out_id_base, v_id_user);
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a subscription base + subscription thread.
#########################################################################################
create procedure mk_subscription_thread
(
	in v_id_subscriptor int,
	in v_id_thread int
)
begin
	call mk_subscription_base(v_id_subscriptor, @out_id_base);

	insert into tbl_subscription_thread
		(id_base, id_thread)
		values(@out_id_base, v_id_thread);
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a subscription base + subscription tag.
#########################################################################################
create procedure mk_subscription_tag
(
	in v_id_subscriptor int,
	in v_id_tag int
)
begin
	call mk_subscription_base(v_id_subscriptor, @out_id_base);

	insert into tbl_subscription_tag
		(id_base, id_tag)
		values(@out_id_base, v_id_tag);
end$
#########################################################################################