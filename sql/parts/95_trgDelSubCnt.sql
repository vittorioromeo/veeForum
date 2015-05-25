#########################################################################################
# TRIGGER
# * Delete subscriptions pointing to threads about to be deleted.
#########################################################################################
create trigger trg_del_subscription_cnt_thread
	before delete on tbl_content_thread
	for each row
begin
	delete from tbl_subscription_thread
	where id_thread = OLD.id;
end$
#########################################################################################


#########################################################################################
# TRIGGER
# * Delete subscriptions pointing to users about to be deleted.
#########################################################################################
create trigger trg_del_subscription_cnt_user
	before delete on tbl_user
	for each row
begin
	delete from tbl_subscription_user
	where id_user = OLD.id;
end$
#########################################################################################



#########################################################################################
# TRIGGER
# * Delete subscriptions pointing to tags about to be deleted.
#########################################################################################
create trigger trg_del_subscription_cnt_tag
	before delete on tbl_tag
	for each row
begin
	delete from tbl_subscription_tag
	where id_tag = OLD.id;
end$
#########################################################################################