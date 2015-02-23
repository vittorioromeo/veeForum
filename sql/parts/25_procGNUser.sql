#########################################################################################
# PROCEDURE
# * Generate notifications for every subscriber to the author of the
#   last created content.
#########################################################################################
create procedure generate_notifications_user
(
	in v_last_content_id int,
	in v_last_content_author int
)
begin
	declare loop_done int default false;
	declare var_id_sub, var_id_sub_base, var_id_sub_tracked_user, 
			current_id_subscriptor int;
	declare itr cursor for select id, id_base, id_user from tbl_subscription_user;
	declare continue handler for not found set loop_done = true;

	open itr;

	label_loop:
	loop
		fetch itr into var_id_sub, var_id_sub_base, var_id_sub_tracked_user;

		if loop_done then
			leave label_loop;
		end if;

		if var_id_sub_tracked_user = v_last_content_author then
			call get_subscriptor(var_id_sub_base, current_id_subscriptor);
			call mk_notification_user(current_id_subscriptor, var_id_sub, v_last_content_id);
		end if;
	end loop;

	close itr;
end$
#########################################################################################