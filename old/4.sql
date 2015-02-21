
# Trigger that creates a notification when a tracked user has created content
create trigger tr_create_notifications_user
	after insert on tbl_content
	for each row
begin
	# Get useful variables
	select id, id_author
	into @last_content_id, @last_content_author
	from tbl_content
	order by id desc limit 1;
	
	# Create notification data for tracked users	
	insert into tbl_notification
		(type, id_user, id_content, seen, creation_timestamp)
		select 0, id_subscriptor, @last_content_id, false, now()
		from tbl_subscription_user
		where id_user = @last_content_author;
end$

create trigger tr_create_notifications_tag
	after insert on tbl_tag_content
	for each row
begin
	# Get useful variables
	select id_tag, id_content
	into @last_tc_tag, @last_tc_content
	from tbl_tag_content
	order by id desc limit 1;
	
	# Create notification data for tracked tags
	insert into tbl_notification
		(type, id_user, id_content, seen, creation_timestamp)
		select 1, id_subscriptor, @last_tc_content, false, now()
		from tbl_subscription_tag 
		where id_tag = @last_tc_tag;		
end$

create trigger tr_create_notifications_thread
	after insert on tbl_post
	for each row
begin
	# Get useful variables
	select id_thread, id_content
	into @last_post_thread, @last_post_content
	from tbl_post
	order by id desc limit 1;
	
	# Create notification data for tracked tags
	insert into tbl_notification
		(type, id_user, id_content, seen, creation_timestamp)
		select 1, id_subscriptor, @last_post_content, false, now()
		from tbl_subscription_thread
		where id_thread = @last_post_thread;		
