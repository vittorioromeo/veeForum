#########################################################################################
# PROCEDURE
# * Initialization procedure
# * Create necessary data for veeForum initalization
#########################################################################################
create procedure initialize_veeForum()
begin
	# Create Superadmin group (ID: 1)
	insert into tbl_group
		(id_parent, name, is_superadmin, can_manage_sections, can_manage_users, 
			 can_manage_groups, can_manage_permissions)
		values(null, 'Superadmin', true, true, true, true, true);

	# Create Basic group (ID: 2) (default registration group)
	insert into tbl_group
		(id_parent, name, is_superadmin, can_manage_sections, can_manage_users, 
			can_manage_groups, can_manage_permissions)
		values(null, 'Basic', false, false, false, false, false);

	# Create SuperAdmin user (ID: 1) with (admin, admin) credentials
	insert into tbl_user
		(id_group, username, password_hash, email, registration_date, firstname, 
			lastname, birth_date)
		values(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 
			'vittorio.romeo@outlook.com', curdate(), 'Vittorio', 'Romeo', curdate());

	# Insert log message with the date of the forum framework installation
	insert into tbl_log
		(type, creation_timestamp, value)
		values(0, now(), 'veeForum initialized');
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Testing procedure
# * Create some test data to speed up development/testing
#########################################################################################
create procedure create_test_data()
begin
	insert into tbl_user
		(id_group, username, password_hash, email, registration_date)
		values(2, 'user1', 'pass1', 'email1', curdate());

	insert into tbl_user
		(id_group, username, password_hash, email, registration_date)
		values(2, 'user2', 'pass2', 'email2', curdate());

	insert into tbl_section
		(id_parent, name)
		values(null, 'section1');

	insert into tbl_group_section_permission
		(id_group, id_section, can_view, can_post, can_create_thread, can_delete_post, 
			can_delete_thread, can_delete_section)
		values(1, 1, true, true, true, true, true, true);

	call mk_subscription_user(2, 3);
end$
#########################################################################################



#########################################################################################
# COMMANDS
# * Initial commands required to set up veeForum
#########################################################################################
call initialize_veeForum()$
call create_test_data()$
#########################################################################################



#########################################################################################
# Copyright (c) 2013-2015 Vittorio Romeo
# License: Academic Free License ("AFL") v. 3.0
# AFL License page: http://opensource.org/licenses/AFL-3.0
#########################################################################################
# http://vittorioromeo.info
# vittorio.romeo@outlook.com
#########################################################################################