drop database if exists db_forum_new$
create database db_forum_new$
use db_forum_new$

# TODO: comment all tables

# Is base of:
# Derives from:
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

# Is base of:
# Derives from:
create table tbl_tag
(
	# Primary key
	id int auto_increment primary key,

	# Name
	value varchar(32) not null unique
)$

# Is base of:
# Derives from:
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

# Is base of:
# Derives from:
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

# Is base of: tbl_content_thread, tbl_content_post
# Derives from:
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

# Is base of:
# Derives from:
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

# Is base of: tbl_content_base
# Derives from:
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

# Is base of: tbl_subscription_thread, tbl_subscription_tag, tbl_subscription_user
# Derives from:
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

# Is base of:
# Derives from: tbl_subscription_base
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

# Is base of:
# Derives from: tbl_subscription_base
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

# Is base of:
# Derives from: tbl_subscription_base
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

# Is base of: tbl_notification_user, tbl_notification_thread, tbl_notification_tag
# Derives from:
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

# Is base of:
# Derives from: tbl_notification_base
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

# Is base of:
# Derives from: tbl_notification_base
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

# Is base of:
# Derives from: tbl_notification_base
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

# Is base of:
# Derives from:
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

# Is base of:
# Derives from: tbl_content_base
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

create table tbl_file_data
(
	# Primary key
	id int auto_increment primary key,

	# Data
	filename varchar(255) not null,
	data blob not null
)$

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



create procedure generate_notifications_user()
begin
	declare loop_done int default false;
	declare var_id_sub, var_id_sub_base, var_id_sub_tracked_user, current_id_subscriptor int;
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

create procedure generate_notifications_thread()
begin
	declare loop_done int default false;
	declare var_id_sub, var_id_sub_base, var_id_sub_tracked_thread, current_id_subscriptor int;
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
			call get_subscriptor(var_id_sub_base, current_id_subscriptor);
			call mk_notification_thread(current_id_subscriptor, var_id_sub);
		end if;
	end loop;

	close itr;
end$

create procedure generate_notifications_tag()
begin
	declare loop_done int default false;
	declare var_id_sub, var_id_sub_base, var_id_sub_tracked_tag, current_id_subscriptor int;
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




# Trigger that creates a notification when a tracked user has created content
create trigger trg_notifications_user
	after insert on tbl_content_base
	for each row
begin
	call generate_notifications_user();
end$

create trigger trg_notifications_thread
	after insert on tbl_content_post
	for each row
begin
	call generate_notifications_thread();
end$

create trigger trg_notifications_tag
	after insert on tbl_tag_content
	for each row
begin
	call generate_notifications_tag();
end$





# Create Superadmin group
insert into tbl_group
	(id_parent, name, is_superadmin, can_manage_sections, can_manage_users, can_manage_groups, can_manage_permissions)
	values(null, 'Superadmin', true, true, true, true, true)$

# Create SuperAdmin user with (admin, admin) credentials
insert into tbl_user
	(id_group, username, password_hash, email, registration_date, firstname, lastname, birth_date)
	values(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'vittorio.romeo@outlook.com', curdate(), 'Vittorio', 'Romeo', curdate())$

# Insert log message with the date of the forum framework installation
insert into tbl_log
	(type, creation_timestamp, value)
	values(0, now(), 'veeForum initialized')$



# Test data
insert into tbl_user
	(id_group, username, password_hash, email, registration_date)
	values(1, 'user1', 'pass1', 'email1', curdate())$

insert into tbl_user
	(id_group, username, password_hash, email, registration_date)
	values(1, 'user2', 'pass2', 'email2', curdate())$

insert into tbl_section
	(id_parent, name)
	values(null, 'section1')$

call mk_subscription_user(2, 3)$