create table Fichier(	
						id int primary key AUTO_INCREMENT,
						nom varchar(27) NOT NULL,
						date_creation date NOT NULL,
						date_modification date NOT NULL,
						nbr_lignes int NOT NULL,
						code_etat int default 2  /* 0 = correct, 1 = incorrect, 2 = non verifié */
					);

create table Motif_rejet(
							id int primary key NOT NULL,
							motif text
						);

create table Det_fichier(
							id int primary key AUTO_INCREMENT,
							id_fichier int NOT NULL,
							num_ligne int NOT NULL,
							contenu_ligne text NOT NULL,
							code_rejet int
						);

ALTER TABLE Det_fichier ADD FOREIGN KEY (id_fichier) REFERENCES Fichier(id);   /* Clés etrangeres*/
-- ALTER TABLE Det_fichier ADD FOREIGN KEY (code_rejet) REFERENCES Motif_rejet(id);

create table Caisse_etrangere(
								id int primary key AUTO_INCREMENT,
								nom text NOT NULL,
								ville text NOT NULL,
								pays text NOT NULL,
								type_remboursement text NOT NULL /* FO = forfait, .... */
							);
create table Assure(
						immatriculation int primary key NOT NULL,
						nom varchar(50),
						prenom varchar(50)
					);

/* Population de la table des motifs de rejets,assurés et caisses etrangeres */

INSERT INTO `Motif_rejet` (`id`, `motif`) 
					VALUES  ('1', 'Assuré invalide'),
					 		('2', 'FOD inexistant'),
					  		('3', 'Date debut et/ou date fin invalide'),
					   		('4', 'Nombre de forfait invalide'),
					    	('5', 'Caisse étrangere incorrecte'),
					 	    ('6', 'Facture inexistante'),
					 		('7', 'Annee apurement invalide ');



INSERT INTO `Assure` (`immatriculation`, `nom`, `prenom`) 
					VALUES 	(104852811, 'CORBATON', 'PIERRE'),
							(106432215, 'RUIZ', 'MARGARITA'),
							(112916112, 'ELBAZ', 'LEON'),
							(115688817, 'LOPEZ', 'FRANCISCO'),
							(136510312, 'ABBADI', 'SAADIA'),
							(186048222, 'LOUDGHIRI', 'YOUSSEF');



INSERT INTO `Caisse_etrangere` (`id`, `nom`, `ville`, `pays`, `type_remboursement`) 
					VALUES	(1, 'INSS DE LIEIDA', 'Lieida', 'Espagne', 'FO'),
							(2, 'INSS DE MALAGA', 'Malaga', 'Espagne', 'FO'),
							(3, 'INSS DE BARCELONA', 'Barcelona', 'Espagne', 'FO'),
							(4, 'INSS  DE CEUTA', 'Ceuta', 'Espagne', 'FO');

--