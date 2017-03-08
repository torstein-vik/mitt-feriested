-- If you get Error Code 1175, Go to Edit -> Preferences -> "SQL Editor" -> "Other" -> uncheck "Safe Updates". Then go to Query -> Reconnect to Server
-- Deleting all previous entries
SET FOREIGN_KEY_CHECKS=0;
DELETE FROM `mitt-feriested`.`attractions`;
DELETE FROM `mitt-feriested`.`tags`;
DELETE FROM `mitt-feriested`.`tagselections`;
SET FOREIGN_KEY_CHECKS=1;

-- Reseting auto_increment
ALTER TABLE attractions AUTO_INCREMENT = 1;
ALTER TABLE tags AUTO_INCREMENT = 1;
ALTER TABLE tagselections AUTO_INCREMENT = 1;

-- Adding attractions
INSERT INTO `mitt-feriested`.`attractions` (name, pagefile, previewimg, weather) VALUES ('test', 'test.php', 'res/main_logo.png', 'Færøyene/Annet/Færøyene'),
                                                                                        ('test2', 'test2.php', 'res/placeholder.jpg', 'Norge/Møre_og_Romsdal/Ålesund/Ålesund');

-- Adding tags
INSERT INTO `mitt-feriested`.`tags` (name) VALUES ('Restaurants'), ('Mountains');

-- Adding tag selections
INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'test' AND (tags.name = 'Restaurants');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'test2' AND (tags.name = 'Restaurants' OR tags.name = 'Mountains');
