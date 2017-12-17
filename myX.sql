/* myX.sql
 * DB schema of the app myX and sample data
 * (c) Joaquín Javier ESTEBAN MARTÍNEZ
 * last update: 2017-12-09
 */

CREATE DATABASE myX
       DEFAULT CHARACTER SET 'utf8'
       DEFAULT COLLATE 'utf8_general_ci';

/* table 'users' */
CREATE TABLE `myX`.`users` (
    userID INTEGER NOT NULL,
    username VARCHAR(16) NOT NULL,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(250) NOT NULL,
    userKind INTEGER,
    CONSTRAINT users_pk PRIMARY KEY (userID)
) ENGINE = InnoDB;
INSERT INTO `myX`.`users` VALUES (1, 'jesteban1972', 'Aquiles0184', 'jesteban1972@me.com', 1);
INSERT INTO `myX`.`users` VALUES (2, 'Fulano', 'f', 'fulano@gmail.com', 1);

/* table 'usersLoggedIn' */
CREATE TABLE `myX`.`usersLoggedIn` (
    sessionID VARCHAR(100) NOT NULL,
    userID INTEGER NOT NULL,
    lastUpdate DATETIME NOT NULL,
    CONSTRAINT usersLoggedIn_pk PRIMARY KEY (sessionID),
    CONSTRAINT usersLoggedIn_user_fk FOREIGN KEY (userID) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

/* table 'countries' */
CREATE TABLE `myX`.`countries` (
    countryID INTEGER NOT NULL,
    name VARCHAR(255),
    user INTEGER NOT NULL,
    CONSTRAINT countries_pk PRIMARY KEY (countryID),
    CONSTRAINT countries_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `myX`.`countries` VALUES (1, 'España', 1); 

/* table 'kinds' */
CREATE TABLE `myX`.`kinds` (
    kindID INTEGER NOT NULL,
    name VARCHAR(255),
    user INTEGER NOT NULL,
    CONSTRAINT kinds_pk PRIMARY KEY (kindID),
    CONSTRAINT kinds_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `myX`.`kinds` VALUES (1, '(generic)', 1);

/* table 'loca' */
CREATE TABLE `myX`.`loca` (
    locusID INTEGER NOT NULL,
    achtung VARCHAR(255),
    name VARCHAR(255),
    country INTEGER,
    kind INTEGER,
    description VARCHAR(510),
    address VARCHAR(255),
    coordinatesExact VARCHAR(255),
    coordinatesGeneric VARCHAR(255),
    www VARCHAR(255),
    user INTEGER NOT NULL,
    INDEX (name),
    CONSTRAINT loca_pk PRIMARY KEY (locusID),
    CONSTRAINT loca_country_fk FOREIGN KEY (country) REFERENCES `myX`.`countries` (countryID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT loca_kind_fk FOREIGN KEY (kind) REFERENCES `myX`.`kinds` (kindID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT loca_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `myX`.`loca` VALUES (1, '', 'Acantilado del amor', 1, 1, 'El acantilado del amor es así y asao', '', '', '', '', 1);

/* table 'practica' */
CREATE TABLE `myX`.`practica` (
    praxisID INTEGER NOT NULL,
    achtung VARCHAR(765),
    locus INTEGER NOT NULL,
    date DATE NOT NULL,
    ordinal VARCHAR(1),
    name VARCHAR(255) NOT NULL,
    rating INTEGER,
    description MEDIUMTEXT,
    tq INTEGER,
    tl INTEGER,
    favorite INTEGER,
    user INTEGER NOT NULL,
    INDEX (date, ordinal),
    CONSTRAINT practica_pk PRIMARY KEY (praxisID),
    CONSTRAINT practica_locus_fk FOREIGN KEY (locus) REFERENCES `myX`.`loca` (locusID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT practica_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT practica_rating_ck CHECK (rating BETWEEN 0 AND 5)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;
/* CHECK constraint is not implemented in mySQL, use a trigger instead */
INSERT INTO `myX`.`practica` VALUES (1, '', 1, '2017-12-08', '', 'Excitante cunnilingus con eyaculación', 4, 'Esta es la experiencia número uno, experiencia vivida con Actea. Aconteció que bla bla bla...', 3, 1, 0, 2);
INSERT INTO `myX`.`practica` VALUES (2, '', 1, '2017-12-10', '', 'Coito en trío desprotegido sin eyaculación', 3, 'Esta es la experiencia número dos, experiencia en trío vivida con Actea y con Eunice. Aconteció que bla bla bla...', 3, 1, 0, 2);

/* table 'amores' */
CREATE TABLE `myX`.`amores` (
    amorID INTEGER NOT NULL,
    achtung VARCHAR(255),
    alias VARCHAR(255) NOT NULL,
    descr1 VARCHAR(255),
    descr2 VARCHAR(255),
    descr3 VARCHAR(255),
    descr4 VARCHAR(255),
    rating INTEGER,
    web VARCHAR(255),
    name VARCHAR(255),
    photo INTEGER,
    telephone VARCHAR(255),
    email VARCHAR(255),
    other VARCHAR(255),
    user INTEGER NOT NULL,
    INDEX (alias),
    CONSTRAINT amores_pk PRIMARY KEY (amorID),
    CONSTRAINT amores_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT amores_rating_ck CHECK (rating BETWEEN 0 AND 5)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;
/* CHECK constraint is not implemented in mySQL, use a trigger instead */
INSERT INTO `myX`.`amores` VALUES (1, '', 'Actea, la de los acantilados', 'Actea es así y asao', 'Tiene un cuerpo tal y tal', 'Tiene un pecho tal y tal', 'Tiene unos genitales tal y tal', 3, '', '', 0, '', '', '', 2);
INSERT INTO `myX`.`amores` VALUES (2, '', 'Eunice, la de fácil victoria, la de rosados brazos', 'Eunice es así y asao', 'Tiene un cuerpo tal y tal', 'Tiene un pecho tal y tal', 'Tiene unos genitales tal y tal', 3, '', '', 0, '', '', '', 2);

/* table 'assignations' */
CREATE TABLE `myX`.`assignations` (
    praxis INTEGER NOT NULL,
    amor INTEGER NOT NULL,
    CONSTRAINT assignations_praxis_fk FOREIGN KEY (praxis) REFERENCES `myX`.`practica` (praxisID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT assignations_amor_fk FOREIGN KEY (amor) REFERENCES `myX`.`amores` (amorID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;
INSERT INTO `myX`.`assignations` VALUES (1, 1);
INSERT INTO `myX`.`assignations` VALUES (2, 1);
INSERT INTO `myX`.`assignations` VALUES (2, 2);