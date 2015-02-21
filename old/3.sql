drop database if exists db_forum_new$
create database db_forum_new$
use db_forum_new$

# TODO: comment all tables

create table tbl_log
(
	# Primary key
	id int auto_increment primary key,

	# Log type
	type int not null default 0,

	# Entry timestamp
	entry_timestamp timestamp not null,

	# Name
	value varchar(512) not null
)$

create table tbl_tag
(
	# Primary key
	id int auto_increment primary key,

	# Name
	value varchar(32) not null
)$

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

create table tbl_content
(
	# Primary key
	id int auto_increment primary key,

	# Data
	creation_date date not null,
	id_author int not null,

	foreign key (id_author)
		references tbl_user(id)
		on update no action
		on delete no action
)$

create table tbl_subscription_thread
(
	# Primary key
	id int auto_increment primary key,

	# Subscriptor user
	id_subscriptor int not null,

	# Target thread
	id_thread int not null,

	foreign key (id_subscriptor)
		references tbl_user(id)
		on update cascade
		on delete cascade,

	foreign key (id_thread)
		references tbl_thread(id)
		on update cascade
		on delete cascade
)$

create table tbl_subscription_user
(
	# Primary key
	id int auto_increment primary key,

	# Subscriptor user
	id_subscriptor int not null,

	# Target user
	id_user int not null,

	foreign key (id_subscriptor)
		references tbl_user(id)
		on update cascade
		on delete cascade,

	foreign key (id_user)
		references tbl_user(id)
		on update cascade
		on delete cascade
)$

create table tbl_subscription_tag
(
	# Primary key
	id int auto_increment primary key,

	# Subscriptor user
	id_subscriptor int not null,

	# Target tag
	id_tag int not null,

	foreign key (id_subscriptor)
		references tbl_user(id)
		on update cascade
		on delete cascade,

	foreign key (id_tag)
		references tbl_tag(id)
		on update cascade
		on delete cascade
)$

create table tbl_notification
(
	# Primary key
	id int auto_increment primary key,

	# Type of notification
	type int not null,

	# Owner of the notification
	id_user int not null;

	# Content created in tracked thread
	id_content int not null,

	# Notification seen?
	seen boolean not null default false,

	# Notification data creation timestamp
	creation_timestamp timestamp not null,

	foreign key (id_user)
		references tbl_user(id)
		on update cascade
		on delete cascade,

	foreign key (id_content)
		references tbl_content(id)
		on update cascade
		on delete cascade
)$

create table tbl_tag_content
(
	# Primary key
	id int auto_increment primary key,

	# Tag
	id_tag int not null,

	# Thread
	id_content int not null,

	foreign key (id_tag)
		references tbl_tag(id)
		on update cascade
		on delete cascade,

	foreign key (id_content)
		references tbl_content(id)
		on update cascade
		on delete cascade
)$

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

create table tbl_thread
(
	# Primary key
	id int auto_increment primary key,

	# Content base
	id_content int not null,

	# Parent section
	id_section int not null,

	# Data
	title varchar(255) not null,

	foreign key (id_content)
		references tbl_content(id)
		on update cascade
		on delete cascade,

	foreign key (id_section)
		references tbl_section(id)
		on update no action
		on delete no action
)$

create table tbl_post
(
	# Primary key
	id int auto_increment primary key,

	# Creation data
	id_content int not null,

	# Parent thread
	id_thread int not null,

	# Data
	contents text not null,

	foreign key (id_content)
		references tbl_content(id)
		on update cascade
		on delete cascade,

	foreign key (id_thread)
		references tbl_thread(id)
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

create table tbl_attachment
(
	# Primary key
	id int auto_increment primary key,

	# Creation data
	id_content int not null,

	# Parent post
	id_post int not null,

	# File data
	id_file_data int not null,

	foreign key (id_content)
		references tbl_content(id)
		on update cascade
		on delete cascade,

	foreign key (id_post)
		references tbl_post(id)
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
	(type, entry_timestamp, value)
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

# Returns the last created content id and author, and also the last notification data id
create procedure get_last_content_data_vars
(
	out last_content_id int,
	out last_content_author int
)
begin
	select id, id_author
	into last_content_id, last_content_author
	from tbl_content
	order by id desc limit 1;
end$

# Trigger that creates a notification when a tracked user has created content
create trigger tr_create_notifications
	after insert on tbl_content
	for each row
begin
	# Get useful variables
	call get_last_content_data_vars(@last_content_id, @last_content_author);
	
	# Create notification data for tracked users	
	insert into tbl_notification
		(type, id_user, id_content, seen, creation_timestamp)
		select 0, id_subscriptor, @last_content_id, false, now()
		from tbl_subscription_user
		where id_user = @last_content_author;

	# Create notification data for tracked rt
	insert into tbl_notification
		(type, id_user, id_content, seen, creation_timestamp)
		select 0, id_subscriptor, @last_content_id, false, now()
		from tbl_subscription_thread 
		where exists
		(
			select tp.id from tbl_subscription_thread as tst inner join tbl_post as tp on tst.id_thread = tp.id_thread
		);


		id_thread = @last_content_id;
end$


# TODO: other triggers

