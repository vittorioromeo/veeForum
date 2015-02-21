create trigger tr_create_notification_user
	after insert on tbl_content 
	for each row 
	begin atomic
		insert into tbl_notification_data
			(id_content, seen, creation_timestamp)
				select ts.id, false, now()
				from tbl_content as tc inner join tbl_subscription_user as ts
				on tc.id_author = ts.id_user
				order by tc.id desc limit 1;

		insert into tbl_notification_user
			(id_notification_data, id_subscription_user)
				select LAST_INSERT_ID(), ts.id
				from tbl_content as tc inner join tbl_subscription_user as ts
				on tc.id_author = ts.id_user
				order by tc.id desc limit 1;
	end;