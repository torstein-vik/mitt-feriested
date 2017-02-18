-- If you get Error Code 1175, Go to Edit -> Preferences -> "SQL Editor" -> "Other" -> uncheck "Safe Updates". Then go to Query -> Reconnect to Server
SET FOREIGN_KEY_CHECKS=0;
DELETE FROM `mitt-feriested`.`attractions`;
SET FOREIGN_KEY_CHECKS=1;
ALTER TABLE attractions AUTO_INCREMENT = 1;
INSERT INTO `mitt-feriested`.`attractions` (name, pagefile) VALUES ('test', 'test.php'),
																   ('test2', 'test2.php');
