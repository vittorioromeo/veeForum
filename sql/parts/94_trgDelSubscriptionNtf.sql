#########################################################################################
# TRIGGER
# * Delete notifications that point to the deleted subscription.
#########################################################################################
create trigger trg_del_subscription_ntf_thread
	before delete on tbl_subscription_thread
	for each row
begin
	delete from tbl_notification_thread
	where id_subscription_thread = OLD.id;
end$
#########################################################################################



#########################################################################################
# TRIGGER
# * Delete notifications that point to the deleted subscription.
#########################################################################################
create trigger trg_del_subscription_ntf_user
	before delete on tbl_subscription_user
	for each row
begin
	delete from tbl_notification_user
	where id_subscription_user = OLD.id;
end$
#########################################################################################



#########################################################################################
# TRIGGER
# * Delete notifications that point to the deleted subscription.
#########################################################################################
create trigger trg_del_subscription_ntf_tag
	before delete on tbl_subscription_tag
	for each row
begin
	delete from tbl_notification_tag
	where id_subscription_tag = OLD.id;
end$
#########################################################################################