-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Jobify
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `Jobify` ;

-- -----------------------------------------------------
-- Schema Jobify
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Jobify` DEFAULT CHARACTER SET utf8 ;
USE `Jobify` ;

-- -----------------------------------------------------
-- Table `Jobify`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`User` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`User` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `passwordhash` VARCHAR(128) NOT NULL,
  `email` VARCHAR(320) NOT NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Country` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Country` (
  `country_id` INT NOT NULL AUTO_INCREMENT,
  `country` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`country_id`),
  UNIQUE INDEX `country_UNIQUE` (`country` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`State`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`State` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`State` (
  `state_id` INT NOT NULL AUTO_INCREMENT,
  `state` VARCHAR(100) NOT NULL,
  `country_id` INT NOT NULL,
  PRIMARY KEY (`state_id`),
  INDEX `fk_State_Country1_idx` (`country_id` ASC),
  CONSTRAINT `fk_State_Country1`
    FOREIGN KEY (`country_id`)
    REFERENCES `Jobify`.`Country` (`country_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Postalcode`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Postalcode` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Postalcode` (
  `postalcode_id` INT NOT NULL AUTO_INCREMENT,
  `Postalcode` VARCHAR(100) NOT NULL,
  `state_id` INT NOT NULL,
  PRIMARY KEY (`postalcode_id`),
  INDEX `fk_Postalcode_State1_idx` (`state_id` ASC),
  CONSTRAINT `fk_Postalcode_State1`
    FOREIGN KEY (`state_id`)
    REFERENCES `Jobify`.`State` (`state_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`City`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`City` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`City` (
  `city_id` INT NOT NULL AUTO_INCREMENT,
  `city` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`city_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`City_Postalcode`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`City_Postalcode` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`City_Postalcode` (
  `City_Postalcode_id` INT NOT NULL AUTO_INCREMENT,
  `postalcode_id` INT NOT NULL,
  `city_id` INT NOT NULL,
  PRIMARY KEY (`City_Postalcode_id`),
  INDEX `fk_Postalcode_has_City_City1_idx` (`city_id` ASC),
  INDEX `fk_Postalcode_has_City_Postalcode1_idx` (`postalcode_id` ASC),
  CONSTRAINT `fk_Postalcode_has_City_Postalcode1`
    FOREIGN KEY (`postalcode_id`)
    REFERENCES `Jobify`.`Postalcode` (`postalcode_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Postalcode_has_City_City1`
    FOREIGN KEY (`city_id`)
    REFERENCES `Jobify`.`City` (`city_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Address` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Address` (
  `address_id` INT NOT NULL AUTO_INCREMENT,
  `street` VARCHAR(100) NOT NULL,
  `number` VARCHAR(100) NOT NULL,
  `additionalinfo` VARCHAR(100) NULL,
  `City_Postalcode_id` INT NOT NULL,
  PRIMARY KEY (`address_id`),
  INDEX `fk_Street_City_Postalcode1_idx` (`City_Postalcode_id` ASC),
  CONSTRAINT `fk_Street_City_Postalcode1`
    FOREIGN KEY (`City_Postalcode_id`)
    REFERENCES `Jobify`.`City_Postalcode` (`City_Postalcode_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Company` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Company` (
  `company_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `slogan` VARCHAR(1000) NULL,
  `description` TEXT NULL,
  `address_id` INT NOT NULL,
  PRIMARY KEY (`company_id`),
  INDEX `fk_Company_User1_idx` (`user_id` ASC),
  INDEX `fk_Company_Street1_idx` (`address_id` ASC),
  CONSTRAINT `fk_Company_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `Jobify`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Company_Street1`
    FOREIGN KEY (`address_id`)
    REFERENCES `Jobify`.`Address` (`address_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Job`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Job` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Job` (
  `job_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `salary` DOUBLE NULL,
  `isvolunteerwork` TINYINT NOT NULL,
  `company_id` INT NOT NULL,
  PRIMARY KEY (`job_id`),
  INDEX `fk_Job_Company1_idx` (`company_id` ASC),
  CONSTRAINT `fk_Job_Company1`
    FOREIGN KEY (`company_id`)
    REFERENCES `Jobify`.`Company` (`company_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Industry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Industry` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Industry` (
  `industry_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `parent_industry_id` INT NULL,
  PRIMARY KEY (`industry_id`),
  INDEX `fk_category_category_idx` (`parent_industry_id` ASC),
  CONSTRAINT `fk_category_category`
    FOREIGN KEY (`parent_industry_id`)
    REFERENCES `Jobify`.`Industry` (`industry_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Education`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Education` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Education` (
  `education_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`education_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Applicant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Applicant` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Applicant` (
  `applicant_id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `birthdate` DATE NOT NULL,
  `description` TEXT NULL,
  `allow_headhunting` TINYINT NOT NULL,
  `user_id` INT NOT NULL,
  `address_id` INT NOT NULL,
  `education_id` INT NULL,
  PRIMARY KEY (`applicant_id`),
  INDEX `fk_Applicant_User1_idx` (`user_id` ASC),
  INDEX `fk_Applicant_Street1_idx` (`address_id` ASC),
  INDEX `fk_Applicant_Education1_idx` (`education_id` ASC),
  CONSTRAINT `fk_Applicant_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `Jobify`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Applicant_Street1`
    FOREIGN KEY (`address_id`)
    REFERENCES `Jobify`.`Address` (`address_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Applicant_Education1`
    FOREIGN KEY (`education_id`)
    REFERENCES `Jobify`.`Education` (`education_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Filetype`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Filetype` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Filetype` (
  `filetype_id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`filetype_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`File`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`File` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`File` (
  `file_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `upldate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL,
  `filetype_id` INT NOT NULL,
  PRIMARY KEY (`file_id`),
  INDEX `fk_File_User1_idx` (`user_id` ASC),
  INDEX `fk_File_Filetype1_idx` (`filetype_id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC, `user_id` ASC, `filetype_id` ASC),
  CONSTRAINT `fk_File_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `Jobify`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_File_Filetype1`
    FOREIGN KEY (`filetype_id`)
    REFERENCES `Jobify`.`Filetype` (`filetype_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Applicant_Industry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Applicant_Industry` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Applicant_Industry` (
  `applicant_industry_id` INT NOT NULL AUTO_INCREMENT,
  `applicant_id` INT NOT NULL,
  `industry_id` INT NOT NULL,
  PRIMARY KEY (`applicant_industry_id`),
  INDEX `fk_Applicant_has_Industry_Industry1_idx` (`industry_id` ASC),
  INDEX `fk_Applicant_has_Industry_Applicant1_idx` (`applicant_id` ASC),
  CONSTRAINT `fk_Applicant_has_Industry_Applicant1`
    FOREIGN KEY (`applicant_id`)
    REFERENCES `Jobify`.`Applicant` (`applicant_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Applicant_has_Industry_Industry1`
    FOREIGN KEY (`industry_id`)
    REFERENCES `Jobify`.`Industry` (`industry_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`ApplicationStatus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`ApplicationStatus` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`ApplicationStatus` (
  `applicationstatus_id` INT NOT NULL AUTO_INCREMENT,
  `status` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`applicationstatus_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Application`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Application` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Application` (
  `application_id` INT NOT NULL AUTO_INCREMENT,
  `text` TEXT NULL,
  `applicationstatus_id` INT NOT NULL,
  `job_id` INT NOT NULL,
  `applicant_id` INT NOT NULL,
  PRIMARY KEY (`application_id`),
  INDEX `fk_application_ApplicationStatus1_idx` (`applicationstatus_id` ASC),
  INDEX `fk_application_Job1_idx` (`job_id` ASC),
  INDEX `fk_application_Applicant1_idx` (`applicant_id` ASC),
  CONSTRAINT `fk_application_ApplicationStatus1`
    FOREIGN KEY (`applicationstatus_id`)
    REFERENCES `Jobify`.`ApplicationStatus` (`applicationstatus_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_application_Job1`
    FOREIGN KEY (`job_id`)
    REFERENCES `Jobify`.`Job` (`job_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_application_Applicant1`
    FOREIGN KEY (`applicant_id`)
    REFERENCES `Jobify`.`Applicant` (`applicant_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Application_File`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Application_File` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Application_File` (
  `Application_File_id` INT NOT NULL AUTO_INCREMENT,
  `application_id` INT NOT NULL,
  `file_id` INT NOT NULL,
  PRIMARY KEY (`Application_File_id`),
  INDEX `fk_application_has_File_File1_idx` (`file_id` ASC),
  INDEX `fk_application_has_File_application1_idx` (`application_id` ASC),
  UNIQUE INDEX `application_id_UNIQUE` (`application_id` ASC, `file_id` ASC),
  CONSTRAINT `fk_application_has_File_application1`
    FOREIGN KEY (`application_id`)
    REFERENCES `Jobify`.`Application` (`application_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_application_has_File_File1`
    FOREIGN KEY (`file_id`)
    REFERENCES `Jobify`.`File` (`file_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Headhunt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Headhunt` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Headhunt` (
  `headhunt_id` INT NOT NULL AUTO_INCREMENT,
  `text` TEXT NULL,
  `job_id` INT NOT NULL,
  `applicant_id` INT NOT NULL,
  PRIMARY KEY (`headhunt_id`),
  INDEX `fk_Headhunt_Job1_idx` (`job_id` ASC),
  INDEX `fk_Headhunt_Applicant1_idx` (`applicant_id` ASC),
  CONSTRAINT `fk_Headhunt_Job1`
    FOREIGN KEY (`job_id`)
    REFERENCES `Jobify`.`Job` (`job_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Headhunt_Applicant1`
    FOREIGN KEY (`applicant_id`)
    REFERENCES `Jobify`.`Applicant` (`applicant_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Favorite`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Favorite` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Favorite` (
  `applicant_job_id` INT NOT NULL AUTO_INCREMENT,
  `applicant_id` INT NOT NULL,
  `job_id` INT NOT NULL,
  PRIMARY KEY (`applicant_job_id`),
  INDEX `fk_Job_Applicant_Applicant1_idx` (`applicant_id` ASC),
  INDEX `fk_Job_Applicant_Job1_idx` (`job_id` ASC),
  CONSTRAINT `fk_Job_Applicant_Job1`
    FOREIGN KEY (`job_id`)
    REFERENCES `Jobify`.`Job` (`job_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Job_Applicant_Applicant1`
    FOREIGN KEY (`applicant_id`)
    REFERENCES `Jobify`.`Applicant` (`applicant_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Job_File`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Job_File` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Job_File` (
  `job_file_id` INT NOT NULL AUTO_INCREMENT,
  `job_id` INT NOT NULL,
  `file_id` INT NOT NULL,
  PRIMARY KEY (`job_file_id`),
  INDEX `fk_Job_File_File1_idx` (`file_id` ASC),
  INDEX `fk_Job_File_Job1_idx` (`job_id` ASC),
  UNIQUE INDEX `job_id_UNIQUE` (`job_id` ASC, `file_id` ASC),
  CONSTRAINT `fk_Job_File_Job1`
    FOREIGN KEY (`job_id`)
    REFERENCES `Jobify`.`Job` (`job_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Job_File_File1`
    FOREIGN KEY (`file_id`)
    REFERENCES `Jobify`.`File` (`file_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Jobify`.`Job_Industry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Jobify`.`Job_Industry` ;

CREATE TABLE IF NOT EXISTS `Jobify`.`Job_Industry` (
  `Job_Industry_id` INT NOT NULL AUTO_INCREMENT,
  `job_id` INT NOT NULL,
  `industry_id` INT NOT NULL,
  PRIMARY KEY (`Job_Industry_id`),
  INDEX `fk_Job_Industry_Industry1_idx` (`industry_id` ASC),
  INDEX `fk_Job_Industry_Job1_idx` (`job_id` ASC),
  CONSTRAINT `fk_Job_Industry_Job1`
    FOREIGN KEY (`job_id`)
    REFERENCES `Jobify`.`Job` (`job_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Job_Industry_Industry1`
    FOREIGN KEY (`industry_id`)
    REFERENCES `Jobify`.`Industry` (`industry_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `Jobify`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (1, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'swie@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (2, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'tgw@jobfiy.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (3, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'bwt@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (4, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'rb@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (5, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'ktm@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (6, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'wule@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (7, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'kada@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (8, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'oble@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (9, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'best@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (10, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'pijui@jobify.com');
INSERT INTO `Jobify`.`User` (`user_id`, `passwordhash`, `email`) VALUES (11, 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', 'wini@jobify.com');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Country`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Country` (`country_id`, `country`) VALUES (1, 'Österreich');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`State`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`State` (`state_id`, `state`, `country_id`) VALUES (1, 'Oberösterreich', 1);
INSERT INTO `Jobify`.`State` (`state_id`, `state`, `country_id`) VALUES (DEFAULT, 'Salzburg', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Postalcode`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Postalcode` (`postalcode_id`, `Postalcode`, `state_id`) VALUES (1, '4020', 1);
INSERT INTO `Jobify`.`Postalcode` (`postalcode_id`, `Postalcode`, `state_id`) VALUES (DEFAULT, '5330', 2);
INSERT INTO `Jobify`.`Postalcode` (`postalcode_id`, `Postalcode`, `state_id`) VALUES (DEFAULT, '4616', 1);
INSERT INTO `Jobify`.`Postalcode` (`postalcode_id`, `Postalcode`, `state_id`) VALUES (DEFAULT, '5310', 1);
INSERT INTO `Jobify`.`Postalcode` (`postalcode_id`, `Postalcode`, `state_id`) VALUES (DEFAULT, '5230', 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`City`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`City` (`city_id`, `city`) VALUES (1, 'Linz');
INSERT INTO `Jobify`.`City` (`city_id`, `city`) VALUES (DEFAULT, 'Marchtrenk');
INSERT INTO `Jobify`.`City` (`city_id`, `city`) VALUES (DEFAULT, 'Mondsee');
INSERT INTO `Jobify`.`City` (`city_id`, `city`) VALUES (DEFAULT, 'Mattighofen');
INSERT INTO `Jobify`.`City` (`city_id`, `city`) VALUES (DEFAULT, 'Fuschl am See');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`City_Postalcode`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`City_Postalcode` (`City_Postalcode_id`, `postalcode_id`, `city_id`) VALUES (1, 1, 1);
INSERT INTO `Jobify`.`City_Postalcode` (`City_Postalcode_id`, `postalcode_id`, `city_id`) VALUES (2, 3, 2);
INSERT INTO `Jobify`.`City_Postalcode` (`City_Postalcode_id`, `postalcode_id`, `city_id`) VALUES (3, 4, 3);
INSERT INTO `Jobify`.`City_Postalcode` (`City_Postalcode_id`, `postalcode_id`, `city_id`) VALUES (4, 5, 4);
INSERT INTO `Jobify`.`City_Postalcode` (`City_Postalcode_id`, `postalcode_id`, `city_id`) VALUES (5, 2, 5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Address`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (1, 'Stallhofnerstrasse', '3', NULL, 4);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (2, 'Am Brunnen ', '1', NULL, 5);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (3, 'Ludwig Szinicz Strasse', '3', NULL, 2);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (4, 'Walter Simmer Strasse', '4', NULL, 3);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (5, 'Edlbacherstrasse', '10', NULL, 1);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (6, 'Muster Strasse', '45', 'a', 1);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (7, 'Muster Strasse', '28', NULL, 2);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (8, 'Muster Strasse', '468', NULL, 3);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (9, 'Muster Gasse', '12', NULL, 4);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (10, 'Musterweg', '8', 'b', 5);
INSERT INTO `Jobify`.`Address` (`address_id`, `street`, `number`, `additionalinfo`, `City_Postalcode_id`) VALUES (11, 'Musterzeile', '5', NULL, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Company`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Company` (`company_id`, `user_id`, `name`, `slogan`, `description`, `address_id`) VALUES (1, 1, 'Swietelsky AG', 'SWIETELSKY - Gefühlt Familie', 'Wenn von „Wir Swietelskys“ die Rede ist, meinen wir nicht etwa die Gründerfamilie, sondern alle, die in unserem Unternehmen mitarbeiten. Denn SWIETELSKY soll sich anfühlen wie eine große Familie, in der wir uns gegenseitig den Rücken stärken, füreinander da sind und in der wir alle zusammenhalten, um unsere wirtschaftliche Zukunft gemeinsam zu gestalten. Wir verstehen, wie wertvoll eine Familie ist, in der man sich wohlfühlt. Deren Vorzüge möchten wir auch am Arbeitsplatz leben!', 5);
INSERT INTO `Jobify`.`Company` (`company_id`, `user_id`, `name`, `slogan`, `description`, `address_id`) VALUES (2, 2, 'TGW Logistics Group', 'Living Logistics', 'Die TGW Logistics Group ist ein international führender Anbieter von Intralogistik-Lösungen mit Hauptsitz in Österreich. Als Stiftungsunternehmen haben wir einen Eigentümer, der im Sinne unserer Kunden und unserer weltweit mehr als 4.400 Mitarbeiter in Europa, Asien und Amerika langfristiges Denken ermöglicht.', 3);
INSERT INTO `Jobify`.`Company` (`company_id`, `user_id`, `name`, `slogan`, `description`, `address_id`) VALUES (3, 3, 'BWT Holding GmbH', 'Menschen und Ideen beflügeln. Seit 1987', 'Die Best Water Technology-Gruppe ist Europas führendes Wassertechnologie-Unternehmen. Über 5.000 Mitarbeiterinnen und Mitarbeiter arbeiten an dem Ziel, Kunden aus Privathaushalten, der Industrie, Gewerbe, Hotels und Kommunen mit innovativen, ökonomischen und ökologischen Wasseraufbereitungs-Technologien ein Höchstmaß an Sicherheit, Hygiene und Gesundheit im täglichen Kontakt mit Wasser zu geben.', 4);
INSERT INTO `Jobify`.`Company` (`company_id`, `user_id`, `name`, `slogan`, `description`, `address_id`) VALUES (4, 4, 'Red Bull GmbH', NULL, 'Inspiriert von funktionalen Getränken aus dem Fernen Osten gründete Dietrich Mateschitz Mitte der 1980er Jahre Red Bull. Er entwickelte ein neues Produkt sowie ein einzigartiges Marketingkonzept und brachte Red Bull Energy Drink am 1. April 1987 in Österreich auf den Markt. Eine völlig neue Produktkategorie – Energy Drinks - war geboren.', 2);
INSERT INTO `Jobify`.`Company` (`company_id`, `user_id`, `name`, `slogan`, `description`, `address_id`) VALUES (5, 5, 'KTM AG', NULL, 'Keine Businessanzüge, sondern Rennanzüge. Keine Langeweile, sondern kurze Wege. Kein „9 to 5“, sondern 100 Prozent. Keine endlosen Meetings, sondern einfach losstarten. Kein 08/15, sondern IQ. Das hat uns zu einer der erfolgreichsten Motorradmarken der letzten Jahrzehnte gemacht. Und wir machen weiter so!', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Job`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (1, 'Spezialist/in Konzernkommunikation', NULL, NULL, 0, 1);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (2, 'Spezialist/in Softwarebetreuung (Personalbereich)', NULL, NULL, 0, 1);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (3, 'Full-Stack Entwickler', NULL, NULL, 0, 2);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (4, '(Junior) Software Developer C# .Net', NULL, NULL, 0, 2);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (5, 'IT Servicedesk Engineer (m/w/i)', NULL, NULL, 0, 3);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (6, 'Lagermitarbeiter:in (m/w/i)', NULL, NULL, 0, 3);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (7, 'SAP Inhouse Consultant*', NULL, NULL, 0, 5);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (8, 'Konstrukteur*', NULL, NULL, 0, 5);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (9, 'Chef De Partie', NULL, NULL, 0, 4);
INSERT INTO `Jobify`.`Job` (`job_id`, `title`, `description`, `salary`, `isvolunteerwork`, `company_id`) VALUES (10, 'Mental Performance and Mental Health Specialist', NULL, NULL, 0, 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Industry`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (1, 'Assistenz', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (2, 'Verwaltung', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (3, 'Beratung', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (4, 'Consulting', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (5, 'Coaching', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (6, 'Training', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (7, 'Einkauf', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (8, 'Logistik', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (9, 'Finanzen', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (10, 'Bankwesen', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (11, 'Führung', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (12, 'Management', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (13, 'Gastronomie', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (14, 'Tourismus', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (15, 'Grafik', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (16, 'Design', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (17, 'IT', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (18, 'EDV', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (19, 'Marketing', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (20, 'PR', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (21, 'Personalwesen', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (22, 'Pharma', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (23, 'Soziales', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (24, 'Produktion', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (25, 'Handwerk', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (26, 'Rechnungswesen', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (27, 'Controlling', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (28, 'Rechtswesen', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (29, 'Sachbearbeitung', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (30, 'Sonstige Berufe', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (31, 'Technik', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (32, 'Ingenieurwesen', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (33, 'Verkauf', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (34, 'Kundenbetreuung', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (35, 'Wissenschaft', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (36, 'Forschung', NULL);
INSERT INTO `Jobify`.`Industry` (`industry_id`, `name`, `parent_industry_id`) VALUES (37, 'Medizin', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Education`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (1, 'High School Diploma');
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (2, 'Vocational or Technical Certifications');
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (3, 'Associate\'s Degree');
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (4, 'Undergraduate (e.g., Bachelor\'s Degree)');
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (5, 'Graduate (e.g., Master\'s Degree)');
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (6, 'Postgraduate');
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (7, 'Postdoctoral');
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (8, 'Doctorate or Ph.D. (Doctor of Philosophy)');
INSERT INTO `Jobify`.`Education` (`education_id`, `name`) VALUES (9, 'Professional Degrees (e.g., M.D., J.D., D.D.S., D.V.M.)');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Applicant`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Applicant` (`applicant_id`, `firstname`, `lastname`, `birthdate`, `description`, `allow_headhunting`, `user_id`, `address_id`, `education_id`) VALUES (1, 'Btephan', 'Serndl', '1999-02-28', 'Call me Stifti', 1, 6, 11, 8);
INSERT INTO `Jobify`.`Applicant` (`applicant_id`, `firstname`, `lastname`, `birthdate`, `description`, `allow_headhunting`, `user_id`, `address_id`, `education_id`) VALUES (2, 'Kavid', 'Daiser', '2000-01-01', 'I iss gern ParaDaiser', 1, 7, 10, 1);
INSERT INTO `Jobify`.`Applicant` (`applicant_id`, `firstname`, `lastname`, `birthdate`, `description`, `allow_headhunting`, `user_id`, `address_id`, `education_id`) VALUES (3, 'Wena', 'Lurmsdobler', '2000-01-01', 'ravioli ravioli give me the formulioli', 1, 8, 9, 2);
INSERT INTO `Jobify`.`Applicant` (`applicant_id`, `firstname`, `lastname`, `birthdate`, `description`, `allow_headhunting`, `user_id`, `address_id`, `education_id`) VALUES (4, 'Pulian', 'Jichler', '2000-01-01', 'I bin da Bulian skurr', 1, 9, 8, 5);
INSERT INTO `Jobify`.`Applicant` (`applicant_id`, `firstname`, `lastname`, `birthdate`, `description`, `allow_headhunting`, `user_id`, `address_id`, `education_id`) VALUES (5, 'Oeon', 'Lberndorfer', '2000-01-01', 'Herr Prammer <3', 1, 10, 7, 7);
INSERT INTO `Jobify`.`Applicant` (`applicant_id`, `firstname`, `lastname`, `birthdate`, `description`, `allow_headhunting`, `user_id`, `address_id`, `education_id`) VALUES (6, 'Wico', 'Nipplinger', '2000-01-01', 'Viertel-Mio-Benzo verletzt deine Gefühle', 1, 11, 6, 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Filetype`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Filetype` (`filetype_id`, `type`) VALUES (1, 'Resume');
INSERT INTO `Jobify`.`Filetype` (`filetype_id`, `type`) VALUES (2, 'Profile Picture');
INSERT INTO `Jobify`.`Filetype` (`filetype_id`, `type`) VALUES (3, 'Motivation letter');
INSERT INTO `Jobify`.`Filetype` (`filetype_id`, `type`) VALUES (4, 'Application');
INSERT INTO `Jobify`.`Filetype` (`filetype_id`, `type`) VALUES (5, 'Job description');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`File`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (1, 'swie_1', '2023-01-01 00:00:00', 1, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (2, 'swie_2', '2023-01-01 00:00:00', 1, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (3, 'tgw_1', '2023-01-01 00:00:00', 2, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (4, 'tgw_2', '2023-01-01 00:00:00', 2, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (5, 'bwt_1', '2023-01-01 00:00:00', 3, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (6, 'bwt_2', '2023-01-01 00:00:00', 3, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (7, 'rb_1', '2023-01-01 00:00:00', 4, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (8, 'rb_2', '2023-01-01 00:00:00', 4, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (9, 'ktm_1', '2023-01-01 00:00:00', 5, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (10, 'ktm_2', '2023-01-01 00:00:00', 5, 3);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (11, 'bwt_logo', '2023-01-01 00:00:00', 3, 2);
INSERT INTO `Jobify`.`File` (`file_id`, `name`, `upldate`, `user_id`, `filetype_id`) VALUES (12, 'girl.png', '2023-01-01 00:00:00', 9, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Applicant_Industry`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Applicant_Industry` (`applicant_industry_id`, `applicant_id`, `industry_id`) VALUES (DEFAULT, 1, 17);
INSERT INTO `Jobify`.`Applicant_Industry` (`applicant_industry_id`, `applicant_id`, `industry_id`) VALUES (DEFAULT, 2, 17);
INSERT INTO `Jobify`.`Applicant_Industry` (`applicant_industry_id`, `applicant_id`, `industry_id`) VALUES (DEFAULT, 3, 17);
INSERT INTO `Jobify`.`Applicant_Industry` (`applicant_industry_id`, `applicant_id`, `industry_id`) VALUES (DEFAULT, 4, 32);
INSERT INTO `Jobify`.`Applicant_Industry` (`applicant_industry_id`, `applicant_id`, `industry_id`) VALUES (DEFAULT, 5, 27);
INSERT INTO `Jobify`.`Applicant_Industry` (`applicant_industry_id`, `applicant_id`, `industry_id`) VALUES (DEFAULT, 6, 20);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`ApplicationStatus`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`ApplicationStatus` (`applicationstatus_id`, `status`) VALUES (1, 'Sent');
INSERT INTO `Jobify`.`ApplicationStatus` (`applicationstatus_id`, `status`) VALUES (2, 'Reviewing');
INSERT INTO `Jobify`.`ApplicationStatus` (`applicationstatus_id`, `status`) VALUES (3, 'Interview');

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Favorite`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Favorite` (`applicant_job_id`, `applicant_id`, `job_id`) VALUES (1, 1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Job_File`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (1, 1, 1);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (2, 2, 2);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (3, 3, 3);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (4, 4, 4);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (5, 5, 5);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (6, 6, 6);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (7, 9, 7);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (8, 10, 8);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (9, 7, 9);
INSERT INTO `Jobify`.`Job_File` (`job_file_id`, `job_id`, `file_id`) VALUES (10, 8, 10);

COMMIT;


-- -----------------------------------------------------
-- Data for table `Jobify`.`Job_Industry`
-- -----------------------------------------------------
START TRANSACTION;
USE `Jobify`;
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 1, 20);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 2, 17);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 3, 17);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 4, 17);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 5, 17);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 6, 8);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 7, 4);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 8, 31);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 9, 13);
INSERT INTO `Jobify`.`Job_Industry` (`Job_Industry_id`, `job_id`, `industry_id`) VALUES (DEFAULT, 10, 23);

COMMIT;

