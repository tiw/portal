ALTER TABLE user ADD UNIQUE (name);

--//@UNDO

ALTER TABLE user DROP UNIQUE (name);

