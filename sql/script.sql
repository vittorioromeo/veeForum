#########################################################################################
# Copyright (c) 2013-2015 Vittorio Romeo
# License: Academic Free License ("AFL") v. 3.0
# AFL License page: http://opensource.org/licenses/AFL-3.0
#########################################################################################
# http://vittorioromeo.info
# vittorio.romeo@outlook.com
#########################################################################################

#########################################################################################
# veeForum forum framework initialization and creation script
#########################################################################################

#########################################################################################
# This script is meant to be run once to create and initialize
# from scratch the whole MySQL veeForum backend.
# Therefore, we drop the database if exists and re-create it.
drop database if exists db_forum_new$
create database db_forum_new$
use db_forum_new$
#########################################################################################




#########################################################################################
# TABLE
# * This table deals with log messages.
#########################################################################################
create table tbl_log
(
	# Primary key
	id int auto_increment primary key,

	# Log type
	type int not null default 0,

	# Entry timestamp
	creation_timestamp timestamp not null,

	# Name
	value varchar(512) not null
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with tag archetypes.
#########################################################################################
create table tbl_tag
(
	# Primary key
	id int auto_increment primary key,

	# Name
	value varchar(32) not null unique
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with groups.
# * Every group row also contains its forum-wide privileges.
#########################################################################################
create table tbl_group
(
	# Primary key
	id int auto_increment primary key,

	# Parent group (null is allowed)
	id_parent int,

	# Name,
	name varchar(255) not null,

	# Privs
	is_superadmin boolean not null default false,
	can_manage_sections boolean not null default false,
	can_manage_users boolean not null default false,
	can_manage_groups boolean not null default false,
	can_manage_permissions boolean not null default false,

	foreign key (id_parent)
		references tbl_group(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with users. 
#########################################################################################
create table tbl_user
(
	# Primary key
	id int auto_increment primary key,

	# Group of the user
	id_group int not null,

	# Credentials
	username varchar(255) not null,
	password_hash varchar(255) not null,
	email varchar(255) not null,
	registration_date date not null,

	# Personal info
	firstname varchar(255),
	lastname varchar(255),
	birth_date date,

	foreign key (id_group)
		references tbl_group(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with sections.
#########################################################################################
create table tbl_section
(
	# Primary key
	id int auto_increment primary key,

	# Parent section (null is allowed)
	id_parent int,

	# Data
	name varchar(255) not null,

	foreign key (id_parent)
		references tbl_section(id)
		on update no action
		on delete no action
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with binary file data.
# * Used for attachments.
#########################################################################################
create table tbl_file_data
(
	# Primary key
	id int auto_increment primary key,

	# Data
	filename varchar(255) not null,
	data blob not null
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with content shared data.
#########################################################################################
# HIERARCHY
# * Is base of: tbl_content_thread, tbl_content_post, 
#               tbl_content_attachment
#########################################################################################
create table tbl_content_base
(
	# Primary key
	id int auto_increment primary key,

	# Data
	creation_timestamp timestamp not null,
	id_author int not null,

	foreign key (id_author)
		references tbl_user(id)
		on update no action
		on delete no action
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with threads, a type of content.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_content_base
#########################################################################################
create table tbl_content_thread
(
	# Primary key
	id int auto_increment primary key,

	# Content base
	id_base int not null,

	# Parent section
	id_section int not null,

	# Data
	title varchar(255) not null,

	foreign key (id_base)
		references tbl_content_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_section)
		references tbl_section(id)
		on update no action
		on delete no action
)$
#########################################################################################




#########################################################################################
# TABLE
# * This table deals with posts, a type of content.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_content_base
#########################################################################################
create table tbl_content_post
(
	# Primary key
	id int auto_increment primary key,

	# Creation data
	id_base int not null,

	# Parent thread
	id_thread int not null,

	# Data
	contents text not null,

	foreign key (id_base)
		references tbl_content_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_thread)
		references tbl_content_thread(id)
		on update no action
		on delete no action
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with attachments, a type of content.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_content_base
#########################################################################################
create table tbl_content_attachment
(
	# Primary key
	id int auto_increment primary key,

	# Creation data
	id_base int not null,

	# Parent post
	id_post int not null,

	# File data
	id_file_data int not null,

	foreign key (id_base)
		references tbl_content_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_post)
		references tbl_content_post(id)
		on update no action
		on delete no action,

	foreign key (id_file_data)
		references tbl_file_data(id)
		on update no action
		on delete no action
)$
#########################################################################################




#########################################################################################
# TABLE
# * This table deals with subscription shared data.
# * Subscriptions allow users to track content or other users.
#########################################################################################
# HIERARCHY
# * Is base of: tbl_subscription_thread, tbl_subscription_tag, 
#               tbl_subscription_user
#########################################################################################
create table tbl_subscription_base
(
	# Primary key
	id int auto_increment primary key,

	# Subscriptor user
	id_subscriptor int not null,

	# Timestamp of beginning
	creation_timestamp timestamp not null,

	# Active/inactive
	active boolean not null default true,

	foreign key (id_subscriptor)
		references tbl_user(id)
		on update cascade
		on delete cascade
)$
#########################################################################################




#########################################################################################
# TABLE
# * This table deals with thread subscriptions.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_subscription_base
#########################################################################################
create table tbl_subscription_thread
(
	# Primary key
	id int auto_increment primary key,

	# Base implementation id
	id_base int not null,

	# Target thread
	id_thread int not null,

	foreign key (id_base)
		references tbl_subscription_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_thread)
		references tbl_content_thread(id)
		on update cascade
		on delete cascade
)$
#########################################################################################




#########################################################################################
# TABLE
# * This table deals with user subscriptions.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_subscription_base
#########################################################################################
create table tbl_subscription_user
(
	# Primary key
	id int auto_increment primary key,

	# Base implementation id
	id_base int not null,

	# Target user
	id_user int not null,

	foreign key (id_base)
		references tbl_subscription_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_user)
		references tbl_user(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with tag subscriptions.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_subscription_base
#########################################################################################
create table tbl_subscription_tag
(
	# Primary key
	id int auto_increment primary key,

	# Base implementation id
	id_base int not null,

	# Target tag
	id_tag int not null,

	foreign key (id_base)
		references tbl_subscription_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_tag)
		references tbl_tag(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with notification shared data.
# * Notifications are created when users need to be notified
#   about content they are subscribed to.
#########################################################################################
# HIERARCHY
# * Is base of: tbl_notification_user, tbl_notification_thread, 
#               tbl_notification_tag
#########################################################################################
create table tbl_notification_base
(
	# Primary key
	id int auto_increment primary key,

	# Receiver of the notification
	id_receiver int not null,

	# Notification seen?
	seen boolean not null default false,

	# Notification data creation timestamp
	creation_timestamp timestamp not null,

	foreign key (id_receiver)
		references tbl_user(id)
		on update cascade
		on delete cascade
)$
#########################################################################################




#########################################################################################
# TABLE
# * This table deals with user notifications.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_notification_base
#########################################################################################
create table tbl_notification_user
(
	# Primary key
	id int auto_increment primary key,

	# Base
	id_base int not null,

	# Subscription
	id_subscription_user int not null,

	foreign key (id_base)
		references tbl_notification_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_subscription_user)
		references tbl_subscription_user(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with thread notifications.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_notification_base
#########################################################################################
create table tbl_notification_thread
(
	# Primary key
	id int auto_increment primary key,

	# Base
	id_base int not null,

	# Subscription
	id_subscription_thread int not null,

	foreign key (id_base)
		references tbl_notification_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_subscription_thread)
		references tbl_subscription_thread(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with tag notifications.
#########################################################################################
# HIERARCHY
# * Derives from: tbl_notification_base
#########################################################################################
create table tbl_notification_tag
(
	# Primary key
	id int auto_increment primary key,

	# Base
	id_base int not null,

	# Subscription
	id_subscription_tag int not null,

	foreign key (id_base)
		references tbl_notification_base(id)
		on update cascade
		on delete cascade,

	foreign key (id_subscription_tag)
		references tbl_subscription_tag(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with the many-to-many tag-content relationship.
#########################################################################################
create table tbl_tag_content
(
	# Primary key
	id int auto_increment primary key,

	# Tag
	id_tag int not null,

	# Content base
	id_content int not null,

	foreign key (id_tag)
		references tbl_tag(id)
		on update cascade
		on delete cascade,

	foreign key (id_content)
		references tbl_content_base(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# TABLE
# * This table deals with the many-to-many group-section permissions 
#   relationship.
#########################################################################################
create table tbl_group_section_permission
(
	# Primary key
	id int auto_increment primary key,

	# Relationship (group <-> section)
	id_group int not null,
	id_section int not null,

	# Data
	can_view boolean not null,
	can_post boolean not null,
	can_create_thread boolean not null,
	can_delete_post boolean not null,
	can_delete_thread boolean not null,
	can_delete_section boolean not null,

	foreign key (id_group)
		references tbl_group(id)
		on update cascade
		on delete cascade,

	foreign key (id_section)
		references tbl_section(id)
		on update cascade
		on delete cascade
)$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a content base and return its ID.
#########################################################################################
create procedure mk_content_base
(
	in v_id_author int,
	out v_created_id int
)
begin
	insert into tbl_content_base
		(id_author, creation_timestamp)
		values(v_id_author, now());

	set v_created_id := LAST_INSERT_ID();
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a content base + content thread.
#########################################################################################
create procedure mk_content_thread
(
	in v_id_author int,
	in v_id_section int,
	in v_title varchar(255)
)
begin
	call mk_content_base(v_id_author, @out_id_base);

	insert into tbl_content_thread
		(id_base, id_section, title)
		values(@out_id_base, v_id_section, v_title);
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a content base + content post.
#########################################################################################
create procedure mk_content_post
(
	in v_id_author int,
	in v_id_thread int,
	in v_contents text
)
begin
	call mk_content_base(v_id_author, @out_id_base);

	insert into tbl_content_post
		(id_base, id_thread, contents)
		values(@out_id_base, v_id_thread, v_contents);
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Create a content base + content attachment.
#########################################################################################
create procedure mk_content_attachment
(
	in v_id_author int,
	in v_id_post int,
	in v_id_file_data int
)
begin
	call mk_content_base(v_id_author, @out_id_base);

	insert into tbl_content_attachment
		(id_base, id_post, id_file_data)
		values(@out_id_base, v_id_post, v_id_file_data);
end$
#########################################################################################



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



#########################################################################################
# PROCEDURE
# * Generate notifications for every subscriber to the thread of the
#   last created post.
#########################################################################################
create procedure generate_notifications_thread()
begin
	declare loop_done int default false;
	declare var_id_sub, var_id_sub_base, var_id_sub_tracked_thread, 
	        current_id_subscriptor int;
	declare itr cursor for select id, id_base, id_thread from tbl_subscription_thread;
	declare continue handler for not found set loop_done = true;

	open itr;

	# Get useful variables
	select id, id_thread
	into @last_post_id, @last_post_thread
	from tbl_content_post
	order by id desc limit 1;

	label_loop:
	loop
		fetch itr into var_id_sub, var_id_sub_base, var_id_sub_tracked_thread;

		if loop_done then
			leave label_loop;
		end if;

		if var_id_sub_tracked_thread = @last_post_thread then
			call get_subscriptor(var_id_sub_base, var_id_sub_tracked_thread, 
				                 current_id_subscriptor);

			# Check if an unseen notification for this thread exists 
			# (TODO: should this be done at all?)
			call check_notification_unseen_existance_thread(current_id_subscriptor, 
				                                            @already_exists);
			if @already_exists = true then
				leave label_loop;
			end if;

			call mk_notification_thread(current_id_subscriptor, var_id_sub);
		end if;
	end loop;

	close itr;
end$
#########################################################################################



#########################################################################################
# PROCEDURE
# * Generate notifications for every subscriber to the tag of the
#   last created content.
#########################################################################################
create procedure generate_notifications_tag()
begin
	declare loop_done int default false;
	declare var_id_sub, var_id_sub_base, var_id_sub_tracked_tag, 
	        current_id_subscriptor int;
	declare itr cursor for select id, id_base, id_tag from tbl_subscription_tag;
	declare continue handler for not found set loop_done = true;

	open itr;

	# Get useful variables
	select id_tag, id_content
	into @last_tc_tag, @last_tc_content
	from tbl_tag_content
	order by id desc limit 1;

	label_loop:
	loop
		fetch itr into var_id_sub, var_id_sub_base, var_id_sub_tracked_tag;

		if loop_done then
			leave label_loop;
		end if;

		if var_id_sub_tracked_tag = @last_tc_tag then
			call get_subscriptor(var_id_sub_base, current_id_subscriptor);
			call mk_notification_tag(current_id_subscriptor, var_id_sub);
		end if;
	end loop;

	close itr;
end$
#########################################################################################



#########################################################################################
# TRIGGER
# * Generate notifications for user subscriptions after content
#   creation.
#########################################################################################
create trigger trg_notifications_user
	after insert on tbl_content_base
	for each row
begin
	call generate_notifications_user();
end$
#########################################################################################



#########################################################################################
# TRIGGER
# * Generate notifications for thread subscriptions after post
#   creation.
#########################################################################################
create trigger trg_notifications_thread
	after insert on tbl_content_post
	for each row
begin
	call generate_notifications_thread();
end$
#########################################################################################



#########################################################################################
# TRIGGER
# * Generate notifications for tag subscriptions after content
#   creation.
#########################################################################################
create trigger trg_notifications_tag
	after insert on tbl_tag_content
	for each row
begin
	call generate_notifications_tag();
end$
#########################################################################################




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
		values(1, 'user1', 'pass1', 'email1', curdate());

	insert into tbl_user
		(id_group, username, password_hash, email, registration_date)
		values(1, 'user2', 'pass2', 'email2', curdate());

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



