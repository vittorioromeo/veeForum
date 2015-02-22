#########################################################################################
# TRIGGER
# * Generate notifications for user subscriptions after content
#   creation.
#########################################################################################
create trigger trg_notifications_user
	after insert on tbl_content_base
	for each row
begin
	call generate_notifications_user(NEW.id, NEW.id_author);
end$
#########################################################################################



#########################################################################################
# TRIGGER
# * Generate notifications for thread subscriptions after post
#   creation.
#########################################################################################
create trigger trg_notifications_thread
	after insert on tbl_content_post
	for each row
begin
	call generate_notifications_thread(NEW.id, NEW.id_thread);
end$
#########################################################################################



#########################################################################################
# TRIGGER
# * Generate notifications for tag subscriptions after content
#   creation.
#########################################################################################
create trigger trg_notifications_tag
	after insert on tbl_tag_content
	for each row
begin
	call generate_notifications_tag(NEW.id_tag, NEW.id_content);
end$
#########################################################################################