create table restokasutajad(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(45) NOT NULL,
password VARCHAR(128) NOT NULL
);


INSERT INTO restokasutajad(username, password) VALUES ('admin2', 'admin');


create table restolauad(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
lauanr INT NOT NULL,
kirjeldus VARCHAR(128),
broneeritud INT NOT NULL,
suurus INT NOT NULL

);

INSERT INTO restolauad(lauanr, kirjeldus, broneeritud, suurus) VALUES (1, 'Akna all asuv laud', 0, 2);