# SitoWebTesina2018
Sito web sviluppato come parte del progetto della mia tesina di maturità 2018 

#### DATABASE #####
CREATE TABLE IF NOT EXISTS users (
id int(11) NOT NULL AUTO_INCREMENT,
username varchar(100) NOT NULL,
email varchar(100) NOT NULL,
password varchar(255) NOT NULL,
PRIMARY KEY (id)
)
CREATE TABLE IF NOT EXISTS misurazioni (
id int(255) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
codice varchar(255) NOT NULL,
temperatura float NOT NULL, 
umidita float NOT NULL, 
volt float NOT NULL, 
ampere float NOT NULL, 
data DATE NOT NULL,
anno YEAR NOT NULL
);
CREATE TABLE IF NOT EXISTS dispositivo (
id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
proprietario varchar(100) NOT NULL  REFERENCES users(id),
codice varchar(255) NOT NULL REFERENCES misurazioni (codice),
nome varchar(255) NOT NULL,
data varchar(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS admin (
id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
username varchar(100) NOT NULL,
email varchar(100) NOT NULL,
password varchar(255) NOT NULL
);

INSERT INTO dispositivo (id, proprietario, codice, nome, data) VALUES (null,"2","vfrrdfgt34","cancella","02/04/2017");
INSERT INTO dispositivo (id, proprietario, codice, nome, data) VALUES (null,"1","uifvniovnivn43fr","mantieni","02/04/2018");

INSERT INTO admin (id,username,email,password) VALUES (null,"mario","admin@gmail.com","a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3");


INSERT INTO misurazioni (id, codice, temperatura, umidita, volt, ampere, data, anno) VALUES (NULL, 'uifvniovnivn43fr','17', '25', '18', '6', '2018-06-14', '2018');
INSERT INTO misurazioni (id, codice, temperatura, umidita, volt, ampere, data, anno) VALUES (NULL, 'uifvniovnivn43fr','15', '20', '17', '7', '2018-06-15', '2018');
INSERT INTO misurazioni (id, codice, temperatura, umidita, volt, ampere, data, anno) VALUES (NULL, 'uifvniovnivn43fr','14', '21', '19', '8', '2018-06-16', '2018');

INSERT INTO misurazioni (id, codice, temperatura, umidita, volt, ampere, data, anno) VALUES (NULL, 'vfrrdfgt34','17', '25', '15', '9', '2018-06-17', '2018');
INSERT INTO misurazioni (id, codice, temperatura, umidita, volt, ampere, data, anno) VALUES (NULL, 'vfrrdfgt34','19', '27', '13', '12', '2018-06-18', '2018');
INSERT INTO misurazioni (id, codice, temperatura, umidita, volt, ampere, data, anno) VALUES (NULL, 'vfrrdfgt34','15', '23', '12', '14', '2018-06-19', '2018');

