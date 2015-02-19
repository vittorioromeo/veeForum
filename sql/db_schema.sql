drop database if exists db_forum;
create database db_forum;
use db_forum;

# TODO: comment all tables

create table tbl_log
(
	# Primary key
	id int auto_increment primary key,

	# Log type
	type int not null,

	# Entry timestamp
	entry_timestamp timestamp not null,

	# Name
	value varchar(512) not null
);

create table tbl_group
(
	# Primary key
	id int auto_increment primary key,

	# Parent group (null is allowed)
	id_parent int,

	# Name,
	name varchar(255) not null,

	# Privileges bitset ('T' for true, 'F' for false)
	privileges varchar(255),

	foreign key (id_parent)
		references tbl_group(id)
		on update no action
		on delete no action
);

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
		on update no action
		on delete no action
);

create table tbl_creation_data
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
);

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
);

create table tbl_thread
(
	# Primary key
	id int auto_increment primary key,

	# Creation data
	id_creation_data int not null,

	# Parent section
	id_section int not null,

	# Data
	title varchar(255) not null,

	foreign key (id_creation_data)
		references tbl_creation_data(id)
		on update cascade
		on delete cascade,

	foreign key (id_section)
		references tbl_section(id)
		on update no action
		on delete no action
);

create table tbl_post
(
	# Primary key
	id int auto_increment primary key,

	# Creation data
	id_creation_data int not null,

	# Parent thread
	id_thread int not null,

	# Data
	contents text not null,

	foreign key (id_creation_data)
		references tbl_creation_data(id)
		on update cascade
		on delete cascade,

	foreign key (id_thread)
		references tbl_thread(id)
		on update no action
		on delete no action
);

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
);


insert into tbl_group(id_parent, name, privileges) values (null, 'Superadmins', 'T');

insert into tbl_user(id_group, username, password_hash, email, registration_date, firstname, lastname, birth_date)
	values('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'vittorio.romeo@outlook.com', curdate(), 'Vittorio', 'Romeo', curdate());

insert into tbl_log(type, entry_timestamp, value) values (0, now(), 'veeForum initialized');