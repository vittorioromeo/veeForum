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