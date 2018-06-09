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
 codice varchar(255) not null,
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
  nome varchar(255) NOT NULL
)
INSERT INTO `misurazioni` (`id`, `codice`, `temperatura`, `umidita`, `volt`, `ampere`, `data`, `anno`) VALUES (NULL, 'uifvniovnivn43fr','17', '25', '18', '6', '2018-06-14', '2018');
INSERT INTO `misurazioni` (`id`, `codice`, `temperatura`, `umidita`, `volt`, `ampere`, `data`, `anno`) VALUES (NULL, 'uifvniovnivn43fr','15', '20', '17', '7', '2018-06-15', '2018');
INSERT INTO `misurazioni` (`id`, `codice`, `temperatura`, `umidita`, `volt`, `ampere`, `data`, `anno`) VALUES (NULL, 'uifvniovnivn43fr','14', '21', '19', '8', '2018-06-16', '2018');