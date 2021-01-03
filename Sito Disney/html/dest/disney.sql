-- MySQL Script generated by MySQL Workbench
-- Sun Jan  3 16:24:44 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mydb` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`film`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`film` ;

CREATE TABLE IF NOT EXISTS `mydb`.`film` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titolo` VARCHAR(50) NOT NULL,
  `data_uscita` DATE NOT NULL,
  `durata` VARCHAR(7) NOT NULL,
  `trama` MEDIUMTEXT NOT NULL,
  `votazione` DECIMAL(2,1) UNSIGNED NULL,
  `prezzo` DOUBLE(4,2) NOT NULL,
  `locandina` BLOB NOT NULL,
  `trailer` BLOB NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `locandina_UNIQUE` (`locandina` ASC) VISIBLE,
  UNIQUE INDEX `trailer_UNIQUE` (`trailer` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cartone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`cartone` ;

CREATE TABLE IF NOT EXISTS `mydb`.`cartone` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(20) NOT NULL,
  `titolo` VARCHAR(50) NOT NULL,
  `data_uscita` DATE NOT NULL,
  `trama` MEDIUMTEXT NOT NULL,
  `votazione` DECIMAL(2,1) UNSIGNED NULL,
  `prezzo` DOUBLE(4,2) NOT NULL,
  `durata` VARCHAR(7) NULL,
  `locandina` BLOB NOT NULL,
  `trailer` BLOB NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `trailer_UNIQUE` (`trailer` ASC) VISIBLE,
  UNIQUE INDEX `locandina_UNIQUE` (`locandina` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`parola_chiave`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`parola_chiave` ;

CREATE TABLE IF NOT EXISTS `mydb`.`parola_chiave` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `testo` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`avatar`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`avatar` ;

CREATE TABLE IF NOT EXISTS `mydb`.`avatar` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `immagine` BLOB NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`utente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`utente` ;

CREATE TABLE IF NOT EXISTS `mydb`.`utente` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL,
  `nome` VARCHAR(30) NOT NULL,
  `cognome` VARCHAR(30) NOT NULL,
  `data_nascita` DATE NOT NULL,
  `email` VARCHAR(40) NOT NULL,
  `paese` VARCHAR(30) NOT NULL,
  `regione` VARCHAR(30) NOT NULL,
  `indirizzo` VARCHAR(50) NOT NULL,
  `password` VARCHAR(25) NOT NULL,
  `avatar_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_utente_avatar1_idx` (`avatar_id` ASC) VISIBLE,
  CONSTRAINT `fk_utente_avatar1`
    FOREIGN KEY (`avatar_id`)
    REFERENCES `mydb`.`avatar` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`recensione`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`recensione` ;

CREATE TABLE IF NOT EXISTS `mydb`.`recensione` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `voto` DECIMAL(2,1) NOT NULL,
  `titolo` VARCHAR(30) NOT NULL,
  `testo` MEDIUMTEXT NOT NULL,
  `data` DATE NOT NULL,
  `utente_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_recensione_utente1_idx` (`utente_id` ASC) VISIBLE,
  CONSTRAINT `fk_recensione_utente1`
    FOREIGN KEY (`utente_id`)
    REFERENCES `mydb`.`utente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`regia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`regia` ;

CREATE TABLE IF NOT EXISTS `mydb`.`regia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(30) NOT NULL,
  `cognome` VARCHAR(30) NOT NULL,
  `anno_nascita` DATE NOT NULL,
  `eta` INT UNSIGNED NOT NULL,
  `nazionalità` VARCHAR(30) NOT NULL,
  `paese_nascita` VARCHAR(30) NOT NULL,
  `biografia` MEDIUMTEXT NOT NULL,
  `foto` BLOB NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `foto_UNIQUE` (`foto` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`personaggio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`personaggio` ;

CREATE TABLE IF NOT EXISTS `mydb`.`personaggio` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descrizione` MEDIUMTEXT NOT NULL,
  `data_nascita` DATE NOT NULL,
  `foto` BLOB NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `foto_UNIQUE` (`foto` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`notizia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`notizia` ;

CREATE TABLE IF NOT EXISTS `mydb`.`notizia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titolo` VARCHAR(30) NOT NULL,
  `fonte` VARCHAR(30) NOT NULL,
  `data_pubblicazione` DATE NOT NULL,
  `descrizione` MEDIUMTEXT NOT NULL,
  `categoria` VARCHAR(30) NOT NULL,
  `immagine` BLOB NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`commento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`commento` ;

CREATE TABLE IF NOT EXISTS `mydb`.`commento` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(30) NOT NULL,
  `email` VARCHAR(40) NOT NULL,
  `testo` MEDIUMTEXT NOT NULL,
  `data` DATE NOT NULL,
  `utente_id` INT UNSIGNED NOT NULL,
  `notizia_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_commento_utente1_idx` (`utente_id` ASC) VISIBLE,
  INDEX `fk_commento_notizia1_idx` (`notizia_id` ASC) VISIBLE,
  CONSTRAINT `fk_commento_utente1`
    FOREIGN KEY (`utente_id`)
    REFERENCES `mydb`.`utente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_commento_notizia1`
    FOREIGN KEY (`notizia_id`)
    REFERENCES `mydb`.`notizia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`ordine`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`ordine` ;

CREATE TABLE IF NOT EXISTS `mydb`.`ordine` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `totale_parziale` DOUBLE(5,2) NOT NULL,
  `spese_spedizione` DOUBLE(5,2) NOT NULL,
  `utente_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ordine_utente1_idx` (`utente_id` ASC) VISIBLE,
  CONSTRAINT `fk_ordine_utente1`
    FOREIGN KEY (`utente_id`)
    REFERENCES `mydb`.`utente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`indirizzo_spedizione`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`indirizzo_spedizione` ;

CREATE TABLE IF NOT EXISTS `mydb`.`indirizzo_spedizione` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(30) NOT NULL,
  `cognome` VARCHAR(30) NOT NULL,
  `indirizzo1` VARCHAR(50) NOT NULL,
  `indirizzo2` VARCHAR(50) NULL,
  `paese` VARCHAR(30) NOT NULL,
  `regione` VARCHAR(30) NULL,
  `citta` VARCHAR(30) NOT NULL,
  `cap` CHAR(5) NOT NULL,
  `telefono` INT UNSIGNED NOT NULL,
  `utente_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_indirizzo_spedizione_utente1_idx` (`utente_id` ASC) VISIBLE,
  CONSTRAINT `fk_indirizzo_spedizione_utente1`
    FOREIGN KEY (`utente_id`)
    REFERENCES `mydb`.`utente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`metodo_pagamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`metodo_pagamento` ;

CREATE TABLE IF NOT EXISTS `mydb`.`metodo_pagamento` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_carta` REAL UNSIGNED NOT NULL,
  `cvv` INT UNSIGNED NOT NULL,
  `data_scadenza` DATE NOT NULL,
  `nome_sulla_carta` VARCHAR(80) NOT NULL,
  `utente_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_metodo_pagamento_utente1_idx` (`utente_id` ASC) VISIBLE,
  CONSTRAINT `fk_metodo_pagamento_utente1`
    FOREIGN KEY (`utente_id`)
    REFERENCES `mydb`.`utente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`gruppo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`gruppo` ;

CREATE TABLE IF NOT EXISTS `mydb`.`gruppo` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipologia utente` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`utente_has_gruppo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`utente_has_gruppo` ;

CREATE TABLE IF NOT EXISTS `mydb`.`utente_has_gruppo` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `utente_id` INT UNSIGNED NOT NULL,
  `gruppo_id` INT UNSIGNED NOT NULL,
  INDEX `fk_utente_has_gruppo_gruppo1_idx` (`gruppo_id` ASC) VISIBLE,
  INDEX `fk_utente_has_gruppo_utente_idx` (`utente_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_utente_has_gruppo_utente`
    FOREIGN KEY (`utente_id`)
    REFERENCES `mydb`.`utente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_utente_has_gruppo_gruppo1`
    FOREIGN KEY (`gruppo_id`)
    REFERENCES `mydb`.`gruppo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`servizi`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`servizi` ;

CREATE TABLE IF NOT EXISTS `mydb`.`servizi` (
  `username` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`gruppo_has_servizi`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`gruppo_has_servizi` ;

CREATE TABLE IF NOT EXISTS `mydb`.`gruppo_has_servizi` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `gruppo_id` INT UNSIGNED NOT NULL,
  `servizi_username` VARCHAR(50) NOT NULL,
  INDEX `fk_gruppo_has_servizi_servizi1_idx` (`servizi_username` ASC) VISIBLE,
  INDEX `fk_gruppo_has_servizi_gruppo1_idx` (`gruppo_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_gruppo_has_servizi_gruppo1`
    FOREIGN KEY (`gruppo_id`)
    REFERENCES `mydb`.`gruppo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gruppo_has_servizi_servizi1`
    FOREIGN KEY (`servizi_username`)
    REFERENCES `mydb`.`servizi` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`film_has_parola_chiave`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`film_has_parola_chiave` ;

CREATE TABLE IF NOT EXISTS `mydb`.`film_has_parola_chiave` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `film_id` INT UNSIGNED NOT NULL,
  `parola_chiave_id` INT UNSIGNED NOT NULL,
  INDEX `fk_film_has_parola_chiave_parola_chiave1_idx` (`parola_chiave_id` ASC) VISIBLE,
  INDEX `fk_film_has_parola_chiave_film1_idx` (`film_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_film_has_parola_chiave_film1`
    FOREIGN KEY (`film_id`)
    REFERENCES `mydb`.`film` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_film_has_parola_chiave_parola_chiave1`
    FOREIGN KEY (`parola_chiave_id`)
    REFERENCES `mydb`.`parola_chiave` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`personaggio_has_parola_chiave`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`personaggio_has_parola_chiave` ;

CREATE TABLE IF NOT EXISTS `mydb`.`personaggio_has_parola_chiave` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `personaggio_id` INT NOT NULL,
  `parola_chiave_id` INT UNSIGNED NOT NULL,
  INDEX `fk_personaggio_has_parola_chiave_parola_chiave1_idx` (`parola_chiave_id` ASC) VISIBLE,
  INDEX `fk_personaggio_has_parola_chiave_personaggio1_idx` (`personaggio_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_personaggio_has_parola_chiave_personaggio1`
    FOREIGN KEY (`personaggio_id`)
    REFERENCES `mydb`.`personaggio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_personaggio_has_parola_chiave_parola_chiave1`
    FOREIGN KEY (`parola_chiave_id`)
    REFERENCES `mydb`.`parola_chiave` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`parola_chiave_has_notizia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`parola_chiave_has_notizia` ;

CREATE TABLE IF NOT EXISTS `mydb`.`parola_chiave_has_notizia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `parola_chiave_id` INT UNSIGNED NOT NULL,
  `notizia_id` INT UNSIGNED NOT NULL,
  INDEX `fk_parola_chiave_has_notizia_notizia1_idx` (`notizia_id` ASC) VISIBLE,
  INDEX `fk_parola_chiave_has_notizia_parola_chiave1_idx` (`parola_chiave_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_parola_chiave_has_notizia_parola_chiave1`
    FOREIGN KEY (`parola_chiave_id`)
    REFERENCES `mydb`.`parola_chiave` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_parola_chiave_has_notizia_notizia1`
    FOREIGN KEY (`notizia_id`)
    REFERENCES `mydb`.`notizia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`regia_has_film`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`regia_has_film` ;

CREATE TABLE IF NOT EXISTS `mydb`.`regia_has_film` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `regia_id` INT UNSIGNED NOT NULL,
  `film_id` INT UNSIGNED NOT NULL,
  INDEX `fk_regia_has_film_film1_idx` (`film_id` ASC) VISIBLE,
  INDEX `fk_regia_has_film_regia1_idx` (`regia_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_regia_has_film_regia1`
    FOREIGN KEY (`regia_id`)
    REFERENCES `mydb`.`regia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_regia_has_film_film1`
    FOREIGN KEY (`film_id`)
    REFERENCES `mydb`.`film` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cartone_has_regia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`cartone_has_regia` ;

CREATE TABLE IF NOT EXISTS `mydb`.`cartone_has_regia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cartone_id` INT UNSIGNED NOT NULL,
  `regia_id` INT UNSIGNED NOT NULL,
  INDEX `fk_cartone_has_regia_regia1_idx` (`regia_id` ASC) VISIBLE,
  INDEX `fk_cartone_has_regia_cartone1_idx` (`cartone_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cartone_has_regia_cartone1`
    FOREIGN KEY (`cartone_id`)
    REFERENCES `mydb`.`cartone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartone_has_regia_regia1`
    FOREIGN KEY (`regia_id`)
    REFERENCES `mydb`.`regia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cartone_has_personaggio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`cartone_has_personaggio` ;

CREATE TABLE IF NOT EXISTS `mydb`.`cartone_has_personaggio` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cartone_id` INT UNSIGNED NOT NULL,
  `personaggio_id` INT NOT NULL,
  INDEX `fk_cartone_has_personaggio_personaggio1_idx` (`personaggio_id` ASC) VISIBLE,
  INDEX `fk_cartone_has_personaggio_cartone1_idx` (`cartone_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cartone_has_personaggio_cartone1`
    FOREIGN KEY (`cartone_id`)
    REFERENCES `mydb`.`cartone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartone_has_personaggio_personaggio1`
    FOREIGN KEY (`personaggio_id`)
    REFERENCES `mydb`.`personaggio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`regia_has_parola_chiave`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`regia_has_parola_chiave` ;

CREATE TABLE IF NOT EXISTS `mydb`.`regia_has_parola_chiave` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `regia_id` INT UNSIGNED NOT NULL,
  `parola_chiave_id` INT UNSIGNED NOT NULL,
  INDEX `fk_regia_has_parola_chiave_parola_chiave1_idx` (`parola_chiave_id` ASC) VISIBLE,
  INDEX `fk_regia_has_parola_chiave_regia1_idx` (`regia_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_regia_has_parola_chiave_regia1`
    FOREIGN KEY (`regia_id`)
    REFERENCES `mydb`.`regia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_regia_has_parola_chiave_parola_chiave1`
    FOREIGN KEY (`parola_chiave_id`)
    REFERENCES `mydb`.`parola_chiave` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cartone_has_parola_chiave`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`cartone_has_parola_chiave` ;

CREATE TABLE IF NOT EXISTS `mydb`.`cartone_has_parola_chiave` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cartone_id` INT UNSIGNED NOT NULL,
  `parola_chiave_id` INT UNSIGNED NOT NULL,
  INDEX `fk_cartone_has_parola_chiave_parola_chiave1_idx` (`parola_chiave_id` ASC) VISIBLE,
  INDEX `fk_cartone_has_parola_chiave_cartone1_idx` (`cartone_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cartone_has_parola_chiave_cartone1`
    FOREIGN KEY (`cartone_id`)
    REFERENCES `mydb`.`cartone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartone_has_parola_chiave_parola_chiave1`
    FOREIGN KEY (`parola_chiave_id`)
    REFERENCES `mydb`.`parola_chiave` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`correlati`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`correlati` ;

CREATE TABLE IF NOT EXISTS `mydb`.`correlati` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cartone_id` INT UNSIGNED NOT NULL,
  `film_id` INT UNSIGNED NOT NULL,
  INDEX `fk_cartone_has_film_film1_idx` (`film_id` ASC) VISIBLE,
  INDEX `fk_cartone_has_film_cartone1_idx` (`cartone_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cartone_has_film_cartone1`
    FOREIGN KEY (`cartone_id`)
    REFERENCES `mydb`.`cartone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartone_has_film_film1`
    FOREIGN KEY (`film_id`)
    REFERENCES `mydb`.`film` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cartone_has_cartone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`cartone_has_cartone` ;

CREATE TABLE IF NOT EXISTS `mydb`.`cartone_has_cartone` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cartone_id` INT UNSIGNED NOT NULL,
  `cartone_associato_id` INT UNSIGNED NOT NULL,
  INDEX `fk_cartone_has_cartone_cartone2_idx` (`cartone_associato_id` ASC) VISIBLE,
  INDEX `fk_cartone_has_cartone_cartone1_idx` (`cartone_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cartone_has_cartone_cartone1`
    FOREIGN KEY (`cartone_id`)
    REFERENCES `mydb`.`cartone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartone_has_cartone_cartone2`
    FOREIGN KEY (`cartone_associato_id`)
    REFERENCES `mydb`.`cartone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`film_correlato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`film_correlato` ;

CREATE TABLE IF NOT EXISTS `mydb`.`film_correlato` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `film_id` INT UNSIGNED NOT NULL,
  `film_correlato_id` INT UNSIGNED NOT NULL,
  INDEX `fk_film_has_film_film2_idx` (`film_correlato_id` ASC) VISIBLE,
  INDEX `fk_film_has_film_film1_idx` (`film_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_film_has_film_film1`
    FOREIGN KEY (`film_id`)
    REFERENCES `mydb`.`film` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_film_has_film_film2`
    FOREIGN KEY (`film_correlato_id`)
    REFERENCES `mydb`.`film` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cartone_preferito`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`cartone_preferito` ;

CREATE TABLE IF NOT EXISTS `mydb`.`cartone_preferito` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cartone_id` INT UNSIGNED NOT NULL,
  `utente_id` INT UNSIGNED NOT NULL,
  INDEX `fk_cartone_has_utente_utente1_idx` (`utente_id` ASC) VISIBLE,
  INDEX `fk_cartone_has_utente_cartone1_idx` (`cartone_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cartone_has_utente_cartone1`
    FOREIGN KEY (`cartone_id`)
    REFERENCES `mydb`.`cartone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartone_has_utente_utente1`
    FOREIGN KEY (`utente_id`)
    REFERENCES `mydb`.`utente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`film_preferito`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`film_preferito` ;

CREATE TABLE IF NOT EXISTS `mydb`.`film_preferito` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `film_id` INT UNSIGNED NOT NULL,
  `utente_id` INT UNSIGNED NOT NULL,
  INDEX `fk_film_has_utente_utente1_idx` (`utente_id` ASC) VISIBLE,
  INDEX `fk_film_has_utente_film1_idx` (`film_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_film_has_utente_film1`
    FOREIGN KEY (`film_id`)
    REFERENCES `mydb`.`film` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_film_has_utente_utente1`
    FOREIGN KEY (`utente_id`)
    REFERENCES `mydb`.`utente` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`media`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`media` ;

CREATE TABLE IF NOT EXISTS `mydb`.`media` (
  `id` INT NOT NULL,
  `file` BLOB NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`cartone_has_media`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`cartone_has_media` ;

CREATE TABLE IF NOT EXISTS `mydb`.`cartone_has_media` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cartone_id` INT UNSIGNED NOT NULL,
  `media_id` INT NOT NULL,
  INDEX `fk_cartone_has_media_media1_idx` (`media_id` ASC) VISIBLE,
  INDEX `fk_cartone_has_media_cartone1_idx` (`cartone_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_cartone_has_media_cartone1`
    FOREIGN KEY (`cartone_id`)
    REFERENCES `mydb`.`cartone` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartone_has_media_media1`
    FOREIGN KEY (`media_id`)
    REFERENCES `mydb`.`media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`media_has_personaggio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`media_has_personaggio` ;

CREATE TABLE IF NOT EXISTS `mydb`.`media_has_personaggio` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `media_id` INT NOT NULL,
  `personaggio_id` INT NOT NULL,
  INDEX `fk_media_has_personaggio_personaggio1_idx` (`personaggio_id` ASC) VISIBLE,
  INDEX `fk_media_has_personaggio_media1_idx` (`media_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_media_has_personaggio_media1`
    FOREIGN KEY (`media_id`)
    REFERENCES `mydb`.`media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_media_has_personaggio_personaggio1`
    FOREIGN KEY (`personaggio_id`)
    REFERENCES `mydb`.`personaggio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`media_has_regia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`media_has_regia` ;

CREATE TABLE IF NOT EXISTS `mydb`.`media_has_regia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `media_id` INT NOT NULL,
  `regia_id` INT UNSIGNED NOT NULL,
  INDEX `fk_media_has_regia_regia1_idx` (`regia_id` ASC) VISIBLE,
  INDEX `fk_media_has_regia_media1_idx` (`media_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_media_has_regia_media1`
    FOREIGN KEY (`media_id`)
    REFERENCES `mydb`.`media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_media_has_regia_regia1`
    FOREIGN KEY (`regia_id`)
    REFERENCES `mydb`.`regia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`media_has_film`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`media_has_film` ;

CREATE TABLE IF NOT EXISTS `mydb`.`media_has_film` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `media_id` INT NOT NULL,
  `film_id` INT UNSIGNED NOT NULL,
  INDEX `fk_media_has_film_film1_idx` (`film_id` ASC) VISIBLE,
  INDEX `fk_media_has_film_media1_idx` (`media_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_media_has_film_media1`
    FOREIGN KEY (`media_id`)
    REFERENCES `mydb`.`media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_media_has_film_film1`
    FOREIGN KEY (`film_id`)
    REFERENCES `mydb`.`film` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`personaggio_has_regia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`personaggio_has_regia` ;

CREATE TABLE IF NOT EXISTS `mydb`.`personaggio_has_regia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `personaggio_id` INT NOT NULL,
  `regia_id` INT UNSIGNED NOT NULL,
  INDEX `fk_personaggio_has_regia_regia1_idx` (`regia_id` ASC) VISIBLE,
  INDEX `fk_personaggio_has_regia_personaggio1_idx` (`personaggio_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_personaggio_has_regia_personaggio1`
    FOREIGN KEY (`personaggio_id`)
    REFERENCES `mydb`.`personaggio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_personaggio_has_regia_regia1`
    FOREIGN KEY (`regia_id`)
    REFERENCES `mydb`.`regia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`personaggio_has_personaggio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`personaggio_has_personaggio` ;

CREATE TABLE IF NOT EXISTS `mydb`.`personaggio_has_personaggio` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `personaggio_id` INT NOT NULL,
  `personaggio_correlato_id` INT NOT NULL,
  INDEX `fk_personaggio_has_personaggio_personaggio2_idx` (`personaggio_correlato_id` ASC) VISIBLE,
  INDEX `fk_personaggio_has_personaggio_personaggio1_idx` (`personaggio_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_personaggio_has_personaggio_personaggio1`
    FOREIGN KEY (`personaggio_id`)
    REFERENCES `mydb`.`personaggio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_personaggio_has_personaggio_personaggio2`
    FOREIGN KEY (`personaggio_correlato_id`)
    REFERENCES `mydb`.`personaggio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`regia_has_regia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`regia_has_regia` ;

CREATE TABLE IF NOT EXISTS `mydb`.`regia_has_regia` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `regia_id` INT UNSIGNED NOT NULL,
  `regia_correlato_id` INT UNSIGNED NOT NULL,
  INDEX `fk_regia_has_regia_regia2_idx` (`regia_correlato_id` ASC) VISIBLE,
  INDEX `fk_regia_has_regia_regia1_idx` (`regia_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_regia_has_regia_regia1`
    FOREIGN KEY (`regia_id`)
    REFERENCES `mydb`.`regia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_regia_has_regia_regia2`
    FOREIGN KEY (`regia_correlato_id`)
    REFERENCES `mydb`.`regia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;