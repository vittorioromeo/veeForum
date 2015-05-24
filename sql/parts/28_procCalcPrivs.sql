#########################################################################################
# PROCEDURE
# * Calculate the final privileges of a user by inheriting them from the group hierarchy
#   they belong to.
#########################################################################################
create procedure calculate_final_privileges
(
	in v_id_user int,
	out v_is_superadmin boolean,
	out v_can_manage_sections boolean,
	out v_can_manage_users boolean,
	out v_can_manage_groups boolean,
	out v_can_manage_permissions boolean
)
begin
	# Set initial out values
	set v_is_superadmin := false;
	set v_can_manage_sections := false;
	set v_can_manage_users := false;
	set v_can_manage_groups := false;
	set v_can_manage_permissions := false;

	# Get user group
	select id_group 
	into @current_id_group
	from tbl_user
	where id = v_id_user;

	# Traverse the hierarchy and set privileges
	label_loop:
	loop
		set @last_id_group := @current_id_group; 

		select id_parent, is_superadmin, can_manage_sections,
			   can_manage_users, can_manage_groups, can_manage_permissions
		into @current_id_group, @p0, @p1, @p2, @p3, @p4
		from tbl_group
		where id = @last_id_group; 

		set v_is_superadmin := v_is_superadmin or @p0;
		set v_can_manage_sections := v_can_manage_sections or @p1;
		set v_can_manage_users := v_can_manage_users or @p2;
		set v_can_manage_groups := v_can_manage_groups or @p3;
		set v_can_manage_permissions := v_can_manage_permissions or @p4;

		if @current_id_group is null then
			leave label_loop;
		end if;
	end loop;
end$
#########################################################################################