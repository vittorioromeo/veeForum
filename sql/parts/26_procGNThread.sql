#########################################################################################
# PROCEDURE
# * Generate notifications for every subscriber to the thread of the
#   last created post.
#########################################################################################
create procedure generate_notifications_thread
(
	in v_last_post_id int,
	in v_last_post_thread int
)
begin
	declare loop_done int default false;
	declare var_id_sub, var_id_sub_base, var_id_sub_tracked_thread, 
			current_id_subscriptor int;
	declare itr cursor for select id, id_base, id_thread from tbl_subscription_thread;
	declare continue handler for not found set loop_done = true;

	open itr;

	label_loop:
	loop
		fetch itr into var_id_sub, var_id_sub_base, var_id_sub_tracked_thread;

		if loop_done then
			leave label_loop;
		end if;

		if var_id_sub_tracked_thread = v_last_post_thread then
			call get_subscriptor(var_id_sub_base, current_id_subscriptor);
			call mk_notification_thread(current_id_subscriptor, var_id_sub, v_last_post_id);
		end if;
	end loop;

	close itr;
end$
#########################################################################################