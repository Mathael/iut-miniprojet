--
-- @author Leboc Philippe, Hugo Sereni
--
INSERT INTO groups VALUES('A1');
INSERT INTO groups VALUES('A2');
INSERT INTO groups VALUES('S');
INSERT INTO groups VALUES('T');

INSERT INTO students VALUES(64512,'Dupond','Bernard','1234','01/01/1990', 'A1');
INSERT INTO students VALUES(64513,'Bond','Jean','maman','02/02/1990', 'A1');
INSERT INTO students VALUES(64514,'Dupond','Celestin','maman','02/02/1990', 'A1');
INSERT INTO students VALUES(64515,'Sereni','Hugo','maman','02/02/1990', 'A2');
INSERT INTO students VALUES(64516,'Leboc','Philippe','maman','02/02/1990', 'A2');
INSERT INTO students VALUES(64517,'Laffont','Matthis','maman','02/02/1990', 'A2');
INSERT INTO students VALUES(64518,'Durand','Ambroise','maman','02/02/1990', 'A2');
INSERT INTO students VALUES(64519,'Dupond','Saturnin','maman','02/02/1990', 'A2');
INSERT INTO students VALUES(64520,'Tireli','Bernard','maman','02/02/1990', 'A1');

INSERT INTO teachers VALUES(23560,'Kerbal','Leonard','pass01','01/01/1950');
INSERT INTO teachers VALUES(23561,'Zsu','Qiwei','pass02','02/02/1945');
INSERT INTO teachers VALUES(23562, 'Du Lac', 'Lancelot', 'pass03', '20/04/1705');
INSERT INTO teachers VALUES(23563, 'De Gall', 'Perceval', 'pass04', '21/09/1805');
INSERT INTO teachers VALUES(23564, 'Pandragon', 'Arthur', 'pass05', '20/04/1705');

INSERT INTO secretaries VALUES(1, 'Escada', 'Nicole', 'secretaire', '01/01/1970');
INSERT INTO secretaries VALUES(2, 'Siera', 'Léa', 'secretaire', '18/08/1987');

INSERT INTO intervals VALUES(0, 'Math', 8, 10, 0, 23560, 'A1');
INSERT INTO intervals VALUES(1, 'Histoire', 10, 12, 0, 23562, 'A1');
INSERT INTO intervals VALUES(2, 'Géographie', 13, 15, 0, 23562, 'A2');
INSERT INTO intervals VALUES(3, 'Techno', 13, 15, 1, 23562, 'A1');
INSERT INTO intervals VALUES(4, 'Histoire', 15, 17, 1, 23562, 'A1');
INSERT INTO intervals VALUES(5, 'Histoire', 13, 15, 3, 23562, 'A1');
INSERT INTO intervals VALUES(6, 'Math', 13, 18, 1, 23562, 'A2');
INSERT INTO intervals VALUES(7, 'Histoire', 15, 16, 3, 23562, 'A1');
INSERT INTO intervals VALUES(8, 'Informatique', 8, 11, 4, 23562, 'A2');
INSERT INTO intervals VALUES(9, 'Informatique', 9, 12, 4, 23562, 'A1');
INSERT INTO intervals VALUES(10, 'Histoire', 14, 15, 4, 23562, 'A2');