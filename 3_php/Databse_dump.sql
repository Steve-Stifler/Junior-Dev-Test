CREATE DATABASE IF NOT EXISTS Catalog;
USE Catalog;

CREATE TABLE IF NOT EXISTS furniture (
	title VARCHAR(100) PRIMARY KEY,
	price INT NOT NULL,
	size VARCHAR(11) NOT NULL,
	material VARCHAR(7) NOT NULL
);

CREATE TABLE IF NOT EXISTS disks (
	title VARCHAR(100) PRIMARY KEY,
	price INT NOT NULL,
	size INT NOT NULL,
	manufacturer VARCHAR(100) NOT NULL
);

delimiter //

CREATE TRIGGER insert_material_check BEFORE INSERT ON furniture
	FOR EACH ROW
	BEGIN
		DECLARE msg varchar(255); 
		IF NEW.material != "wood" AND NEW.material != "plastic" THEN
			SET msg = "Material must be wood or plastic!";
			SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = msg; 
		END IF;
	END
//

CREATE TRIGGER update_material_check BEFORE UPDATE ON furniture
	FOR EACH ROW
	BEGIN
		DECLARE msg varchar(255); 
		IF NEW.material != "wood" AND NEW.material != "plastic" THEN
			SET msg = "Material must be wood or plastic!";
			SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = msg; 
		END IF;
	END
//

delimiter ;

INSERT INTO furniture VALUES ("furniture1", 100, "100x100x100", "wood");
INSERT INTO furniture VALUES ("furniture2", 111, "10x10x10", "wood");
INSERT INTO furniture VALUES ("furniture3", 56757, "235x17x987", "plastic");

INSERT INTO disks VALUES ("disk1", 22, 1024, "Company One");
INSERT INTO disks VALUES ("disk2", 40, 228, "Company Two");
INSERT INTO disks VALUES ("disk3", 1, 720, "Company THREE POINT ONE");