/* myX.sql
 * myX DB schema
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last update: 2018-04-18
 */

CREATE DATABASE myX
       DEFAULT CHARACTER SET 'utf8'
       DEFAULT COLLATE 'utf8_general_ci';

/* table 'users' */
CREATE TABLE `myX`.`users` (
    `userID`        INTEGER NOT NULL,
    `username`      VARCHAR(16) NOT NULL,
    `password`      VARCHAR(50) NOT NULL,
    `email`         VARCHAR(250) NOT NULL,
    `birthdate`     DATE NOT NULL,
    `defaultGenre`  INTEGER,
    `descr1`        VARCHAR(255),
    `descr2`        VARCHAR(255),
    `descr3`        VARCHAR(255),
    `descr4`        VARCHAR(255),
    `GUILang`       INTEGER DEFAULT 1,
    `resultsPerPage`INTEGER DEFAULT 25,
    `listsOrder`    INTEGER DEFAULT 1,
    `userKind`      INTEGER DEFAULT 2,
    CONSTRAINT users_pk PRIMARY KEY (userID)
) ENGINE=InnoDB;

/* table 'usersLoggedIn' */
CREATE TABLE `myX`.`usersLoggedIn` (
    `sessionID`     VARCHAR(100) NOT NULL,
    `userID`        INTEGER NOT NULL,
    `lastUpdate`    DATETIME NOT NULL,
    CONSTRAINT usersLoggedIn_pk PRIMARY KEY (sessionID),
    CONSTRAINT usersLoggedIn_user_fk FOREIGN KEY (userID) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

/* table 'countries' */
CREATE TABLE `myX`.`countries` (
    `countryID` INTEGER NOT NULL,
    `name`      VARCHAR(255),
    `user`      INTEGER NOT NULL,
    CONSTRAINT countries_pk PRIMARY KEY (countryID),
    CONSTRAINT countries_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* table 'kinds' */
CREATE TABLE `myX`.`kinds` (
    `kindID`    INTEGER NOT NULL,
    `name`      VARCHAR(255),
    `user`      INTEGER NOT NULL,
    CONSTRAINT kinds_pk PRIMARY KEY (kindID),
    CONSTRAINT kinds_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* table 'loca' */
CREATE TABLE `myX`.`loca` (
    `locusID`       INTEGER NOT NULL,
    `achtung`       VARCHAR(255),
    `name`          VARCHAR(255) NOT NULL,
    `rating`        INTEGER,
    `address`       VARCHAR(255),
    `country`       INTEGER,
    `kind`          INTEGER,
    `descr`         MEDIUMTEXT,
    `coordExact`    VARCHAR(255),
    `coordGeneric`  VARCHAR(255),
    `web`           VARCHAR(255),
    `user`          INTEGER NOT NULL,
    INDEX (name),
    CONSTRAINT loca_pk PRIMARY KEY (locusID),
    CONSTRAINT loca_country_fk FOREIGN KEY (country) REFERENCES `myX`.`countries` (countryID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT loca_kind_fk FOREIGN KEY (kind) REFERENCES `myX`.`kinds` (kindID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT loca_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* table 'practica' */
CREATE TABLE `myX`.`practica` (
    `praxisID`  INTEGER NOT NULL,
    `achtung`   VARCHAR(765),
    `name`      VARCHAR(255) NOT NULL,
    `rating`    INTEGER,
    `favorite`  INTEGER,
    `locus`     INTEGER NOT NULL,
    `date`      DATE NOT NULL,
    `ordinal`   VARCHAR(1),
    `descr`     MEDIUMTEXT,
    `tq`        INTEGER,
    `tl`        INTEGER,
    `user`      INTEGER NOT NULL,
    INDEX (date, ordinal),
    CONSTRAINT practica_pk PRIMARY KEY (praxisID),
    CONSTRAINT practica_locus_fk FOREIGN KEY (locus) REFERENCES `myX`.`loca` (locusID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT practica_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT practica_rating_ck CHECK (rating BETWEEN 0 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/* CHECK constraint is not implemented in mySQL, use a trigger instead */

/* table 'amores' */
CREATE TABLE `myX`.`amores` (
    `amorID`    INTEGER NOT NULL,
    `achtung`   VARCHAR(255),
    `alias`     VARCHAR(255) NOT NULL,
    `rating`    INTEGER,
    `genre`     INTEGER,
    `descr1`    VARCHAR(510),
    `descr2`    VARCHAR(510),
    `descr3`    VARCHAR(510),
    `descr4`    VARCHAR(510),
    `web`       VARCHAR(255),
    `name`      VARCHAR(255),
    `photo`     INTEGER,
    `phone`     VARCHAR(255),
    `email`     VARCHAR(255),
    `other`     VARCHAR(255),
    `user`      INTEGER NOT NULL,
    INDEX (alias),
    CONSTRAINT amores_pk PRIMARY KEY (amorID),
    CONSTRAINT amores_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT amores_rating_ck CHECK (rating BETWEEN 0 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/* CHECK constraint is not implemented in mySQL, use a trigger instead */

/* table 'assignations' */
CREATE TABLE `myX`.`assignations` (
    `praxis`    INTEGER NOT NULL,
    `amor`      INTEGER NOT NULL,
    CONSTRAINT assignations_praxis_fk FOREIGN KEY (praxis) REFERENCES `myX`.`practica` (praxisID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT assignations_amor_fk FOREIGN KEY (amor) REFERENCES `myX`.`amores` (amorID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

/* table 'queries' */
CREATE TABLE `myX`.`queries` (
    `queryID`   INTEGER NOT NULL,
    `name`      VARCHAR(255),
    `descr`     VARCHAR(510),
    `user`      INTEGER NOT NULL,
    CONSTRAINT queries_pk PRIMARY KEY (queryID),
    CONSTRAINT queries_user_fk FOREIGN KEY (user) REFERENCES `myX`.`users` (userID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;