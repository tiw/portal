CREATE TABLE user_point (
    id int(8) unsigned NOT NULL auto_increment,
    id_user int(8) NOT NULL,
    id_point int(8) NOT NULL,
    primary key (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--//@UNDO

DROP TABLE user_point;
