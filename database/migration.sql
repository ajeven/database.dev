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

CREATE TABLE players (
  id       INT UNSIGNED NOT NULL AUTO_INCREMENT,
  team_id  INT UNSIGNED NOT NULL,
  name     VARCHAR(255) NOT NULL,
  position VARCHAR(50),
  PRIMARY KEY (id),
  FOREIGN KEY (team_id) REFERENCES teams (id)
);

CREATE TABLE games (
  visitor_team_id   INT UNSIGNED NOT NULL,
  local_team_id     INT UNSIGNED NOT NULL,
  visitor_team_runs INT UNSIGNED NOT NULL,
  local_team_runs   INT UNSIGNED NOT NULL,
  game_date         DATETIME     NOT NULL,
  PRIMARY KEY (visitor_team_id, local_team_id, game_date),
  FOREIGN KEY (visitor_team_id) REFERENCES teams (id),
  FOREIGN KEY (local_team_id) REFERENCES teams (id)
);
