#########################################################################################
# TRIGGER
# * Delete notification base left behind by derived notification types.
#########################################################################################
create trigger trg_del_notification_base_thread
	after delete on tbl_notification_thread
	for each row
begin
	delete from tbl_notification_base
	where id = OLD.id_base;
end$
########################################################################################



#########################################################################################
# TRIGGER
# * Delete notification base left behind by derived notification types.
#########################################################################################
create trigger trg_del_notification_base_user
	after delete on tbl_notification_user
	for each row
begin
	delete from tbl_notification_base
	where id = OLD.id_base;
end$
########################################################################################



#########################################################################################
# TRIGGER
# * Delete notification base left behind by derived notification types.
#########################################################################################
create trigger trg_del_notification_base_tag
	after delete on tbl_notification_tag
	for each row
begin
	delete from tbl_notification_base
	where id = OLD.id_base;
end$
########################################################################################