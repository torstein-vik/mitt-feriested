
-- SQL script for adding attractions

-- If you get Error Code 1175, Go to Edit -> Preferences -> "SQL Editor" -> "Other" -> uncheck "Safe Updates". Then go to Query -> Reconnect to Server

-- Deleting all previous entries
SET FOREIGN_KEY_CHECKS=0;
DELETE FROM `mitt-feriested`.`attractions`;
DELETE FROM `mitt-feriested`.`tags`;
DELETE FROM `mitt-feriested`.`tagselections`;
SET FOREIGN_KEY_CHECKS=1;

-- Reseting auto_increment
ALTER TABLE `mitt-feriested`.attractions AUTO_INCREMENT = 1;
ALTER TABLE `mitt-feriested`.tags AUTO_INCREMENT = 1;
ALTER TABLE `mitt-feriested`.tagselections AUTO_INCREMENT = 1;

-- Adding tags
INSERT INTO `mitt-feriested`.`tags` (name, previewimg) VALUES ('Things to do', 'res/placeholder.jpg'), ('Hotel', 'res/placeholder.jpg'), ('Food', 'res/placeholder.jpg'), ('Travel', 'res/placeholder.jpg');

-- Adding attractions
INSERT INTO `mitt-feriested`.`attractions` (name, pagefile, previewimg, weather) VALUES ('test', 'attr/test.php', 'res/main_logo.png', 'Færøyene/Annet/Færøyene'),
                                                                                        ('test2', 'attr/test2.php', 'res/placeholder.jpg', 'Norge/Møre_og_Romsdal/Ålesund/Ålesund');

-- Adding tag selections
INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'test' AND (tags.name = 'Restaurants');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'test2' AND (tags.name = 'Restaurants' OR tags.name = 'Mountains');

