SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Database of mitt-feriested
-- -----------------------------------------------------

CREATE SCHEMA IF NOT EXISTS `mitt-feriested` DEFAULT CHARACTER SET utf8 ;
USE `mitt-feriested` ;

-- User table
CREATE TABLE IF NOT EXISTS `mitt-feriested`.`users` (
  `userid` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `passhash` BINARY(32) NOT NULL,
  `passsalt` BINARY(32) NOT NULL,
  `privilege` ENUM('user', 'admin') NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB;

-- Attaction table
CREATE TABLE IF NOT EXISTS `mitt-feriested`.`attractions` (
  `attractionid` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `pagefile` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`attractionid`))
ENGINE = InnoDB;

-- Tip table
CREATE TABLE IF NOT EXISTS `mitt-feriested`.`tips` (
  `tipid` INT NOT NULL AUTO_INCREMENT,
  `userid` INT NOT NULL,
  `attractionid` INT NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` VARCHAR(45) NOT NULL,
  `content` TEXT NOT NULL,
  PRIMARY KEY (`tipid`),
  FOREIGN KEY (`userid`)
    REFERENCES `mitt-feriested`.`users` (`userid`),
  FOREIGN KEY (`attractionid`)
    REFERENCES `mitt-feriested`.`attractions` (`attractionid`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
