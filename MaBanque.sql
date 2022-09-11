-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';


-- -----------------------------------------------------
-- Table `mb_categorie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mb_categorie` ;

CREATE TABLE IF NOT EXISTS `mb_categorie` (
	`bi_idCategorie` INT NOT NULL AUTO_INCREMENT,
	`bi_idCategorieParent` INT NULL,
	`bs_nomCategorie` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`bi_idCategorie`),
	INDEX `fk_categorie_categorie_idx` (`bi_idCategorieParent` ASC),
	CONSTRAINT `fk_categorie_categorie`
		FOREIGN KEY (`bi_idCategorieParent`)
		REFERENCES `mb_categorie` (`bi_idCategorie`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mb_utilisateur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mb_utilisateur` ;

CREATE TABLE IF NOT EXISTS `mb_utilisateur` (
	`bi_idUtilisateur` INT NOT NULL AUTO_INCREMENT,
	`bs_loginUtilisateur` VARCHAR(100) NOT NULL,
	`bs_motDePasseUtilisateur` VARCHAR(100) NOT NULL,
	`bs_nomUtilisateur` VARCHAR(45) NOT NULL,
	`bs_prenomUtilisateur` VARCHAR(45) NOT NULL,
	`bs_emailUtilisateur` VARCHAR(45) NOT NULL,
	PRIMARY KEY (`bi_idUtilisateur`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mb_compte`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mb_compte` ;

CREATE TABLE IF NOT EXISTS `mb_compte` (
	`bi_idCompte` INT NOT NULL AUTO_INCREMENT,
	`bi_idUtilisateurCompte` INT NOT NULL,
	`bs_nomCompte` VARCHAR(45) NOT NULL,
	PRIMARY KEY (`bi_idCompte`),
	INDEX `fk_compte_utilisateur_idx` (`bi_idUtilisateurCompte` ASC),
	CONSTRAINT `fk_compte_utilisateur`
		FOREIGN KEY (`bi_idUtilisateurCompte`)
		REFERENCES `mb_utilisateur` (`bi_idUtilisateur`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mb_operation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mb_operation` ;

CREATE TABLE IF NOT EXISTS `mb_operation` (
	`bi_idOperation` INT NOT NULL AUTO_INCREMENT,
	`bs_libelleOperation` VARCHAR(255) NOT NULL,
	`bd_dateOperation` DATE NOT NULL,
	`bi_idCompteOperation` INT NULL,
	`bi_idCatagorieOperation` INT NULL,
	`bf_debitOperation` FLOAT NULL,
	`bf_creditOperation` FLOAT NULL,
	`bb_pointageOperation` TINYINT NOT NULL DEFAULT 0,
	`bd_datePointageOperation` DATE NULL,
	PRIMARY KEY (`bi_idOperation`),
	INDEX `fk_operation_compte_idx` (`bi_idCompteOperation` ASC),
	INDEX `fk_operation_categorie_idx` (`bi_idCatagorieOperation` ASC),
	CONSTRAINT `fk_operation_compte`
		FOREIGN KEY (`bi_idCompteOperation`)
		REFERENCES `mb_compte` (`bi_idCompte`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION,
	CONSTRAINT `fk_operation_categorie`
		FOREIGN KEY (`bi_idCatagorieOperation`)
		REFERENCES `mb_categorie` (`bi_idCategorie`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mb_projet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mb_projet` ;

CREATE TABLE IF NOT EXISTS `mb_projet` (
	`bi_idProjet` INT NOT NULL AUTO_INCREMENT,
	`bi_idUtilisateurProjet` INT NOT NULL,
	`bs_nomProjet` VARCHAR(45) NOT NULL,
	`bf_objectifProjet` FLOAT NOT NULL,
	`bf_etatProjet` FLOAT NOT NULL,
	`bd_dateFinaleProjet` DATE NOT NULL,
	PRIMARY KEY (`bi_idProjet`),
	INDEX `fk_projet_utilisateur_idx` (`bi_idUtilisateurProjet` ASC),
	CONSTRAINT `fk_projet_utilisateur`
		FOREIGN KEY (`bi_idUtilisateurProjet`)
		REFERENCES `mb_utilisateur` (`bi_idUtilisateur`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
