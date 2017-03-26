
-- SQL script for adding attractions

-- If you get Error Code 1175, Go to Edit -> Preferences -> "SQL Editor" -> "Other" -> uncheck "Safe Updates". Then go to Query -> Reconnect to Server

-- Deleting all previous entries
SET FOREIGN_KEY_CHECKS=0;
DELETE FROM `mitt-feriested`.`attractions`;
DELETE FROM `mitt-feriested`.`tags`;
DELETE FROM `mitt-feriested`.`tagselections`;
SET FOREIGN_KEY_CHECKS=1;

-- Reseting auto_increment
ALTER TABLE `mitt-feriested`.`attractions` AUTO_INCREMENT = 1;
ALTER TABLE `mitt-feriested`.`tags` AUTO_INCREMENT = 1;
ALTER TABLE `mitt-feriested`.`tagselections` AUTO_INCREMENT = 1;

-- Adding tags
INSERT INTO `mitt-feriested`.`tags` (name, previewimg) VALUES ('Things to do', 'res/placeholder.jpg'), ('Hotel', 'res/placeholder.jpg'), ('Food', 'res/placeholder.jpg'), ('Travel', 'res/placeholder.jpg');

-- Adding attractions
INSERT INTO `mitt-feriested`.`attractions` (name, pagefile, previewimg, weather) VALUES ('Koks Restaurant', 'attr/koks.php', 'attr/koks.jpg', 'NONE'),
                                                                                        ('Áarstova', 'attr/aarstova.php', 'attr/aarstova.jpg', 'NONE'),
                                                                                        ('Ræst', 'attr/raest.php', 'attr/ræst.jpg', 'NONE'),
                                                                                        ('Barbara Fishhouse', 'attr/barbara.php', 'attr/barbara.jpg', 'NONE'),
                                                                                        ('Kirkjubøargarður', 'attr/kirkjuboeargarthur.php', 'attr/kirkjubøargarður.jpg', 'Færøyene/Sandoy/Kirkjubøur/'),
                                                                                        ('Gásadalur', 'attr/gasadalur.php', 'attr/gásadalur.jpg', 'Færøyene/Vágar/Gásadalur/'),
                                                                                        ('Slættaratindur', 'attr/slaettaratindur.php', 'attr/slættaratindur.jpg', 'Færøyene/Eysturoy/Slættaratindur/'),
                                                                                        ('Birdwatching', 'attr/birdwatching.php', 'attr/birdwatching.jpg', 'NONE'),
                                                                                        ('Diving', 'attr/diving.php', 'attr/diving.jpg', 'NONE'),
                                                                                        ('Plane', 'attr/plane.php', 'attr/plane.jpg', 'NONE'),
                                                                                        ('Boat', 'attr/boat.php', 'attr/boat.jpg', 'NONE'),
                                                                                        ('Hotel Føroyar', 'attr/hotelfoeroyar.php', 'attr/hotelføroyar.jpeg', 'NONE'),
                                                                                        ('Hotel Streym Hotell', 'attr/streym.php', 'attr/streym.jpeg', 'NONE'),
                                                                                        ('Hotel Tórshavn', 'attr/hoteltorshavn.php', 'attr/hoteltorshavn.jpg', 'NONE'),
                                                                                        ('Hotel Vagar', 'attr/vagar.php', 'attr/vagar.jpg', 'NONE');

-- Adding tag selections
INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Koks Restaurant' AND (tags.name = 'Food');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Áarstova' AND (tags.name = 'Food');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Ræst' AND (tags.name = 'Food');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Barbara Fishhouse' AND (tags.name = 'Food');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Kirkjubøargarður' AND (tags.name = 'Things to do');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Gásadalur' AND (tags.name = 'Things to do');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Slættaratindur' AND (tags.name = 'Things to do');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Birdwatching' AND (tags.name = 'Things to do');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Diving' AND (tags.name = 'Things to do');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Plane' AND (tags.name = 'Travel');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Boat' AND (tags.name = 'Travel');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Hotel Føroyar' AND (tags.name = 'Hotel' OR tags.name = 'Food');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Hotel Streym Hotell' AND (tags.name = 'Hotel');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Hotel Tórshavn' AND (tags.name = 'Hotel' OR tags.name = 'Food');

INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`
WHERE attractions.name = 'Hotel Vagar' AND (tags.name = 'Hotel');

