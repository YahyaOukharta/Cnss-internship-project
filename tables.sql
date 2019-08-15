create table Fichier(	
						id int primary key AUTO_INCREMENT,
						nom varchar(27) NOT NULL,
						date_creation date NOT NULL,
						date_modification date NOT NULL,
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
ALTER TABLE Det_fichier ADD FOREIGN KEY (code_rejet) REFERENCES Motif_rejet(id);

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

/* Population de la table des motifs de rejets */

INSERT INTO `Motif_rejet` (`id`, `motif`) 
					VALUES  ('1', 'Assuré invalide'),
					 		('2', 'FOD inexistant'),
					  		('3', 'Date debut et/ou date fin invalide'),
					   		('4', 'Nombre de forfait invalide'),
					    	('5', 'Caisse étrangere incorrecte'),
					 	    ('6', 'Facture inexistante'),
					 		('7', 'Annee apurement invalide ');