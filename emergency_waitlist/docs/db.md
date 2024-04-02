Entities

Admin
 - first_name : varchar(50)
 - last_name  : varchar(50)
 - login_password : varchar(50)
 - id           : varchar() or integer
 -
Patient
 - first_name : varchar(50)
 - last_name  : varchar(50)
 - login_code : varchar(3)
 - injury_severity : integer
 - start_of_wait   : time
Waitlist
 - Patient_id : varchar
 - size       : integer
 - average_wait_time : time
