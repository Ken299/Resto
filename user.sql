create table users(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(45) NOT NULL,
	password VARCHAR(128) NOT NULL,
	nimi VARCHAR(100),
	rights INT NOT NULL
);

INSERT INTO TABLE users (username, password, rights) VALUES ('admin', SHA2('admin', 512), 1);