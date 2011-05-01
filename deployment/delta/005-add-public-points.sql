INSERT INTO point (name, link, logo_url, is_public) 
VALUES 
("google mail", "http://mail.google.com", "https://mail.google.com/mail/images/2/5/logo4.png", 1),
("basecamp", "http://basecamphq.com/", "", 1);


--//@UNDO


DELETE FROM point WHERE name IN ('google mail', 'basecamp');
