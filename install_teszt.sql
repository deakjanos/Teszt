CREATE TABLE emberek(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
vezeteknev VARCHAR(30),
keresztnev VARCHAR(30),
nem VARCHAR(30),
varos VARCHAR(30)
);
CREATE TABLE varosok(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
varosnev VARCHAR(30)
);
INSERT INTO `varosok` VALUES (1, 'Budapest');
INSERT INTO `varosok` VALUES (2, 'Cenk');
INSERT INTO `varosok` VALUES (3, 'Encs');
INSERT INTO `varosok` VALUES (4, 'Miskolc');
INSERT INTO `varosok` VALUES (5, 'Szeged');
INSERT INTO `varosok` VALUES (6, 'Szerencs');