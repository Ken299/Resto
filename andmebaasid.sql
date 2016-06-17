CREATE TABLE bronn(
	bronn_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	arv INT(3),
	nimi VARCHAR(50),
	email VARCHAR(50),
	telefon VARCHAR(50),
	kuupaev VARCHAR(10),
	aeg VARCHAR(10),
	lisa TEXT,
	confirmed TINYINT (1) DEFAULT 0
);

CREATE TABLE postitused(
	post_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	img VARCHAR(150),
	pealkiri VARCHAR(50),
	sisu MEDIUMTEXT
);

INSERT INTO bronn (arv, nimi, email, telefon, kuupaev, aeg, lisa) VALUES ('3', 'sabddf', 'weerwge@wef.cwef', '23234345', '2016-06-20', '18:00', 'wefwefwefwe');