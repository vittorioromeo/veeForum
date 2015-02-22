#########################################################################################
# TRIGGER
# * Delete subscription base left behind by derived subscription types.
#########################################################################################
create trigger trg_del_subscription_base_thread
	after delete on tbl_subscription_thread
	for each row
begin
	delete from tbl_subscription_base
	where id = OLD.id_base;
end$
########################################################################################



#########################################################################################
# TRIGGER
# * Delete subscription base left behind by derived subscription types.
#########################################################################################
create trigger trg_del_subscription_base_user
	after delete on tbl_subscription_user
	for each row
begin
	delete from tbl_subscription_base
	where id = OLD.id_base;
end$
########################################################################################



#########################################################################################
# TRIGGER
# * Delete subscription base left behind by derived subscription types.
#########################################################################################
create trigger trg_del_subscription_base_tag
	after delete on tbl_subscription_tag
	for each row
begin
	delete from tbl_subscription_base
	where id = OLD.id_base;
end$
########################################################################################