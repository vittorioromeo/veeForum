#########################################################################################
# TRIGGER
# * Delete content base left behind by derived content types.
#########################################################################################
create trigger trg_del_content_base_thread
	after delete on tbl_content_thread
	for each row
begin
	delete from tbl_content_base
	where id = OLD.id_base;
end$
########################################################################################



#########################################################################################
# TRIGGER
# * Delete content base left behind by derived content types.
#########################################################################################
create trigger trg_del_content_base_post
	after delete on tbl_content_post
	for each row
begin
	delete from tbl_content_base
	where id = OLD.id_base;
end$
########################################################################################



#########################################################################################
# TRIGGER
# * Delete content base left behind by derived content types.
#########################################################################################
create trigger trg_del_content_base_attachment
	after delete on tbl_content_attachment
	for each row
begin
	delete from tbl_content_base
	where id = OLD.id_base;
end$
########################################################################################