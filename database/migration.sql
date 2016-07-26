DROP DATABASE IF EXISTS the_league_db;

CREATE DATABASE the_league_db;

USE the_league_db;

CREATE TABLE teams (
  id      INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name    VARCHAR(100) NOT NULL,
  stadium VARCHAR(100) NOT NULL,
  league  ENUM ('national', 'american'),
  PRIMARY KEY (id)
);