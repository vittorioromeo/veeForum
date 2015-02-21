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