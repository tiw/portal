ALTER TABLE point DROP COLUMN position;
ALTER TABLE user_point ADD COLUMN 
    position int(8) unsigned NOT NULL default 0;
