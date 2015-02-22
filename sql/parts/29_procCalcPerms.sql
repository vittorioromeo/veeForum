#########################################################################################
# PROCEDURE
# * Calculate the final permissions of a user by inheriting them from the group hierarchy
# * they belong to, towards a specific section.
#########################################################################################
create procedure calculate_final_permissions
(
	in v_id_user int,
	in v_id_section int,
	out v_can_view boolean,
	out v_can_post boolean,
	out v_can_create_thread boolean,
	out v_can_delete_post boolean,
	out v_can_delete_thread boolean,
	out v_can_delete_section boolean
)
begin
	# Set initial out values
	set v_can_view := false;
	set v_can_post := false;
	set v_can_create_thread := false;
	set v_can_delete_post := false;
	set v_can_delete_thread := false;
	set v_can_delete_section := false;

	# Get user group
	select id_group 
	into @current_id_group
	from tbl_user
	where id = v_id_user;

	# Traverse the hierarchy and set permissions
	label_loop:
	loop
		set @last_id_group := @current_id_group; 

		select id_parent
		into @current_id_group
		from tbl_group
		where id = @last_id_group; 

		select can_view, can_post, can_create_thread, 
			   can_delete_post, can_delete_thread, can_delete_section
		into @p0, @p1, @p2, @p3, @p4, @p5
		from tbl_group_section_permission
		where id_group = @last_id_group and id_section = v_id_section; 

		set v_can_view := v_can_view or @p0;
		set v_can_post := v_can_post or @p1;
		set v_can_create_thread := v_can_create_thread or @p2;
		set v_can_delete_post := v_can_delete_post or @p3;
		set v_can_delete_thread := v_can_delete_thread or @p4;
		set v_can_delete_section := v_can_delete_section or @p5;

		if @current_id_group is null then
			leave label_loop;
		end if;
	end loop;
end$
#########################################################################################