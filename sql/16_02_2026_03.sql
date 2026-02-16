-- Schema for dispatch_mere and dispatch_fille
-- Run this file to create the tables for dispatch management

CREATE TABLE dispatch_mere (
	`id_dispatch_mere` INT NOT NULL AUTO_INCREMENT,
	`id_ville` INT DEFAULT NULL,
	`date_dispatch` DATETIME NOT NULL,
	PRIMARY KEY (`id_dispatch_mere`)
)

CREATE TABLE dispatch_fille (
	`id_dispatch_fille` INT NOT NULL AUTO_INCREMENT,
	`id_dispatch_mere` INT NOT NULL,
	`id_produit` INT NOT NULL,
	`quantite` INT NOT NULL DEFAULT 0,
	PRIMARY KEY (`id_dispatch_fille`)
)


