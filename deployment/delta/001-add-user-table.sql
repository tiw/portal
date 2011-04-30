CREATE TABLE user (
    id int(11) unsigned NOT NULL auto_increment,
    name varchar(50) NOT NULL,
    password varchar(128) NOT NULL,
    primary key (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--//@UNDO

DROP TABLE user;
