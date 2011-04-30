CREATE TABLE point (
    id int(11) unsigned NOT NULL auto_increment,
    name varchar(255) NOT NULL,
    link varchar(255) NOT NULL,
    logo_url varchar(255),
    position int(8) unsigned NOT NULL default 0,
    is_public tinyint(1) DEFAULT 0,
    primary key (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--//@UNDO

DROP TABLE point;
