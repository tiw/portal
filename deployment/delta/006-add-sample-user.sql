INSERT INTO user (name, password) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3');

--//@UNDO

DELETE FROM user where name = 'admin'
