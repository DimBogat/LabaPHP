DROP DATABASE IF EXISTS country_db;
CREATE DATABASE country_db;
-- Использование созданной базы данных
USE country_db;
-- Создание таблицы Countries
CREATE TABLE Countries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  shortName VARCHAR(255) NOT NULL UNIQUE,
  fullName VARCHAR(255) NOT NULL,
  isoAlpha2 VARCHAR(2) NOT NULL UNIQUE,
  isoAlpha3 VARCHAR(3) NOT NULL UNIQUE,
  isoNumeric INT NOT NULL UNIQUE,
  population BIGINT UNSIGNED NOT NULL,
  square DECIMAL(10, 2) NOT NULL
);