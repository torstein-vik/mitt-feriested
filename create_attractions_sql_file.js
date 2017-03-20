var fs = require('fs');

// Parsing JSON

var attractions = JSON.parse(fs.readFileSync('attractions.json', 'utf8'));

var sql = `
-- SQL script for adding attractions

-- If you get Error Code 1175, Go to Edit -> Preferences -> "SQL Editor" -> "Other" -> uncheck "Safe Updates". Then go to Query -> Reconnect to Server

-- Deleting all previous entries
SET FOREIGN_KEY_CHECKS=0;
DELETE FROM \`mitt-feriested\`.\`attractions\`;
DELETE FROM \`mitt-feriested\`.\`tags\`;
DELETE FROM \`mitt-feriested\`.\`tagselections\`;
SET FOREIGN_KEY_CHECKS=1;

-- Reseting auto_increment
ALTER TABLE \`mitt-feriested\`.\`attractions\` AUTO_INCREMENT = 1;
ALTER TABLE \`mitt-feriested\`.\`tags\` AUTO_INCREMENT = 1;
ALTER TABLE \`mitt-feriested\`.\`tagselections\` AUTO_INCREMENT = 1;
`

if(attractions.tags.length == 0){
    console.log("Error! Must have at least one tag!");
    return;
}

pTags = []

attractions.tags.forEach(function(tag){
    pTags.push([tag.name, tag.previewimg].join("', '"));
});

sql += "\n-- Adding tags\n";
sql += "INSERT INTO `mitt-feriested`.`tags` (name, previewimg) VALUES ('" + pTags.join("'), ('") + "');\n";

if(attractions.attractions.length == 0){
    console.log("Error! Must have at least one attraction!");
    return;
}

pAttrs = []

attractions.attractions.forEach(function(attraction){
    pAttrs.push([attraction.name, attraction.pagefile, attraction.previewimg, attraction.weather].join("', '"));
});

spaces = "                                                                                        ";

sql += "\n-- Adding attractions\n";
sql += "INSERT INTO `mitt-feriested`.`attractions` (name, pagefile, previewimg, weather) VALUES ('" + pAttrs.join("'),\n" + spaces + "('") + "');\n";



sql += "\n-- Adding tag selections\n";

attractions.attractions.forEach(function(attraction){
    sql += "INSERT INTO `mitt-feriested`.`tagselections` (attractionid, tagid) SELECT attractionid, tagid FROM `mitt-feriested`.`attractions`, `mitt-feriested`.`tags`\n";
    sql += "WHERE attractions.name = '"+attraction.name+"' AND (tags.name = '" + attraction.tags.join("' OR tags.name = '") + "');\n";
    sql += "\n";
});



console.log(sql);

fs.writeFile("create_attractions.sql", sql, function(err) {
    if(err) {
        return console.log(err);
    }

    console.log("Saved and complete");
});
