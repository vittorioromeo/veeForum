#########################################################################################
# PROCEDURE
# * Generate notifications for every subscriber to the author of the
#   last created content.
#########################################################################################
create procedure generate_notifications_user()
begin
	declare loop_done int default false;
	declare var_id_sub, var_id_sub_base, var_id_sub_tracked_user, 
			current_id_subscriptor int;
	declare itr cursor for select id, id_base, id_user from tbl_subscription_user;
	declare continue handler for not found set loop_done = true;

	open itr;

	# Get useful variables
	select id, id_author
	into @last_content_id, @last_content_author
	from tbl_content_base
	order by id desc limit 1;

	label_loop:
	loop
		fetch itr into var_id_sub, var_id_sub_base, var_id_sub_tracked_user;

		if loop_done then
			leave label_loop;
		end if;

		if var_id_sub_tracked_user = @last_content_author then
			call get_subscriptor(var_id_sub_base, current_id_subscriptor);
			call mk_notification_user(current_id_subscriptor, var_id_sub);
		end if;
	end loop;

	close itr;
end$
#########################################################################################