-- MariaDB 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: mysql-suba.alwaysdata.net    Database: suba_arcadia
-- ------------------------------------------------------
-- Server version	10.11.8-MariaDB



-- Table structure for table `animaux`


DROP TABLE IF EXISTS `animaux`;

CREATE TABLE `animaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `etat` varchar(255) DEFAULT NULL,
  `race` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id_habitats` int(11) DEFAULT NULL,
  `compteur` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_habitats` (`id_habitats`),
  CONSTRAINT `fk_habitats` FOREIGN KEY (`id_habitats`) REFERENCES `habitats` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `animaux`


LOCK TABLES `animaux` WRITE;

INSERT INTO `animaux` VALUES (1,'Marty (Z├¿bre)','Il est en bonne sante','Equides','670cd5e6accde.jpg',1,133),(2,'Zuri (Girafe)','Elle commence ├á montrer des signes d\'├óge ','Ongules','girafe.jpg',1,10),(3,'Speedy (Autruche)','Il perd des plumes mais rien d\'alarmant','Struthio camelus','autruche$=.jpg',1,22),(4,'Dumbo (Elephant)','Des signe de vieillissement','Loxodonta','elephant.jpg',1,199),(5,'Simba (Lion)','En bonne sante','Panthera','lion.jpg',1,239),(6,'Rhino (Rhinoc├®ros)','Il est en leger surpoids','Ceratotherium','rhinoceros.jpg',1,40),(35,'Max (Gorille)','Un peu fatigu├® ','Gorilla ','6734611dc7163.jpg',2,37),(36,'Tucano (Toucan)','L├®g├¿re blessure ├á l\'aile, mais reste plein d\'├®nergie.','Ramphastos sulfuratus','6734657f85ea4.jpg',2,1),(37,'Kaa (Serpent)',' Il souffre d\'une l├®g├¿re d├®shydratation mais il se remet doucement avec des soins appropri├®s. ','Python regius','67346711b2d27.jpg',2,9),(38,'Shere Khan (Tigre)','Il prend l\'age mais reste en bonne sant├®','Panthera tigris tigris','6734678537732.jpg',2,16),(39,'Rango (Camel├®on)','L├®g├¿re perte de couleurs due ├á un stress temporaire, mais rien de grave','Furcifer pardalis','673469c976e58.jpg',2,1),(40,'Georges (Chimpanz├®)','Jeune et en bonne sant├®','Pan troglodytes','67346b647c12f.jpg',2,4),(41,'Guido (Crocodile)','Guido est en excellente sant├®','Crocodylus ','67346eca75a9a.jpg',3,5),(42,'Tina (Grue)','Elle est en bonne sant├®','Grus grus','6735ab16a3c50.jpg',3,1),(43,'Donald (Canard)','Il montre des signe de fatigue et se repose au bord de l\'eau','Anas platyrhynchos','6735ab36c8ab6.jpg',3,1),(44,'Zazu (H├®ron)','Zazu est en parfaite forme, il se nourrit bien','Ardea cinerea','6734786ccab99.jpg',3,4),(45,'Benjamin (Castor)','Benjamin pr├®sente une l├®g├¿re blessure ├á la queue et se repose dans sa hutte.','Castor canadensis','673478cf02be9.jpg',3,1),(46,'Bambi (Cerf)','En pleine forme, toujours rapide et agile','Odocoileus virginianus','67347934e8450.jpg',3,4);

UNLOCK TABLES;


-- Table structure for table `avis`


DROP TABLE IF EXISTS `avis`;

CREATE TABLE `avis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `visibilite` tinyint(1) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_users` (`id_users`),
  CONSTRAINT `fk_id_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `avis`


LOCK TABLES `avis` WRITE;

INSERT INTO `avis` VALUES (1,'Oceana','Le Zoo dÔÇÖarcadia est une destination id├®ale pour  une sortie en famille ou entre amis. Je recommande vivement cette visite  ├á tous les amoureux des animaux et de la nature.',1,NULL),(2,'Zoe','JÔÇÖai r├®cemment visit├® le Zoo dÔÇÖArcadia et jÔÇÖai ├®t├®  agr├®ablement surpris par la qualit├® de lÔÇÖexp├®rience. Le zoo est bien  entretenu et les animaux semblent bien soign├®s.',1,NULL),(3,'Marc','Le Zoo est une v├®ritable merveille pour les amoureux des animaux et de la nature. D├¿s lÔÇÖentr├®e, on est accueilli par des all├®es ombrag├®es et des sons apaisants de la nature.',1,NULL),(6,'Nilou','Les animaux semblent heureux et en bonne sant├®, une visite incontournable!',1,NULL),(13,'Leatitia','Un moment inoubliable passe en famille, je recommande!',1,12),(15,'Ishan','Un zoo magnifique avec des habitats vari├®s et bien entretenus.',1,12);

UNLOCK TABLES;


-- Table structure for table `habitats`


DROP TABLE IF EXISTS `habitats`;

CREATE TABLE `habitats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `descriptif` text DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `habitats_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `habitats`


LOCK TABLES `habitats` WRITE;
INSERT INTO `habitats` VALUES (1,'Savane','La savane est un ├®cosyst├¿me unique, compos├® de vastes ├®tendues herbeuses parsem├®es d\'arbres et d\'arbustes adapt├®s aux conditions climatiques de la r├®gion. Elle abrite une incroyable diversit├® d\'animaux, chacun ayant d├®velopp├® des adaptations sp├®cifiques pour survivre dans cet environnement. Entre les rochers, les points d\'eau et les zones ombrag├®es, cet agencement recr├®e parfaitement les caract├®ristiques naturelles de la savane.','L\'habitat est bien adapt├®, mais l\'ajout de plus de points d\'ombre et de refuges naturels am├®liorerait le confort des animaux pendant les journ├®es chaudes.','uploads/savane.jpg',11),(2,'Jungle','Nous avons recr├®e la jungle dans le zoo pour imiter l habitat naturel des animaux tropicaux. On y trouve une v├®g├®tation dense, des arbres imposants et des plantes grimpantes, offrant un refuge ├á une vari├®t├® d esp├¿ces comme les singes, les oiseaux exotiques et les reptiles. Ce cadre permet aux visiteurs de d├®couvrir la richesse et la diversit├® de la faune et de la flore tropicales tout en sensibilisant ├á la conservation des ├®cosyst├¿mes naturels.','Des structures d\'escalade suppl├®mentaires favoriserait un enrichissement comportemental optimal.','uploads/jungle.jpg',11),(3,'Marais','Le marais est un habitat des zones humides, permettant aux visiteurs de d├®couvrir des esp├¿ces comme les grenouilles, les tortues et les oiseaux aquatiques. Ce type d enclos favorise le bien-├¬tre des animaux en imitant leur environnement naturel et joue un r├┤le ├®ducatif en sensibilisant ├á la pr├®servation des ├®cosyst├¿mes humides.','Plus de v├®g├®tation aquatique diversifi├®e offrirait davantage de cachettes et de zones de reproduction.','uploads/marais.jpg',11);
UNLOCK TABLES;


-- Table structure for table `images`


DROP TABLE IF EXISTS `images`;

CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `donnee_image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Table structure for table `nourrissage`


DROP TABLE IF EXISTS `nourrissage`;

CREATE TABLE `nourrissage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_nourriture` varchar(255) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `date_repas` date DEFAULT NULL,
  `heure_repas` time DEFAULT NULL,
  `id_animal` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_animaux` (`id_animal`),
  KEY `fk_users` (`id_users`),
  CONSTRAINT `fk_animaux` FOREIGN KEY (`id_animal`) REFERENCES `animaux` (`id`),
  CONSTRAINT `fk_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `nourrissage`


LOCK TABLES `nourrissage` WRITE;

INSERT INTO `nourrissage` VALUES (1,'herbe',500,'2024-09-23','18:05:20',1,12),(2,'feuille',70,'2024-09-23','18:30:05',2,12),(3,'granules',2,'2024-09-23','18:36:07',3,12),(4,'herbe',100,'2024-09-23','18:01:07',4,12),(5,'viande',7,'2024-09-23','18:12:07',5,12),(13,'feuille',10,'2024-11-06','20:29:00',6,12),(15,'granule',50,'2024-11-06','07:30:00',1,12);

UNLOCK TABLES;


-- Table structure for table `rapport_vet`


DROP TABLE IF EXISTS `rapport_vet`;

CREATE TABLE `rapport_vet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `la_date` date DEFAULT NULL,
  `rapport` text DEFAULT NULL,
  `id_animal` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_animal` (`id_animal`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `rapport_vet_ibfk_1` FOREIGN KEY (`id_animal`) REFERENCES `animaux` (`id`),
  CONSTRAINT `rapport_vet_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `rapport_vet`


LOCK TABLES `rapport_vet` WRITE;

INSERT INTO `rapport_vet` VALUES (2,'2024-11-07','l├®ger surpoids, diminuer le repas du soir',6,11),(3,'2024-11-07','bonne sante',1,11),(4,'2024-11-07','bonne ├®tat',2,11),(5,'2024-11-07','l├®ger surpoids',6,11),(6,'2024-11-07',' signe de vieillissement ',4,11),(7,'2024-11-07','bonne sante ',5,11),(8,'2024-11-07','bonne etat ',3,11),(9,'2024-11-07','augmente de 100g',1,11),(10,'2024-11-07','attention particuliere',4,11),(11,'2024-11-07','aucun changement',2,11);

UNLOCK TABLES;


-- Table structure for table `role`


DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `role`


LOCK TABLES `role` WRITE;

INSERT INTO `role` VALUES (1,'admin'),(2,'employe'),(3,'veterinaire');

UNLOCK TABLES;

-- Table structure for table `services`


DROP TABLE IF EXISTS `services`;

CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `descriptif` text DEFAULT 'NULL',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data for table `services`


LOCK TABLES `services` WRITE;

INSERT INTO `services` VALUES (1,'Restaurant','Bienvenue ├á notre Restaurant !\r\n\r\nApr├¿s une journ├®e passionnante ├á explorer les merveilles de notre zoo, prenez une pause bien m├®rit├®e dans notre espace de restauration. Nous proposons une vari├®t├® de plats d├®licieux pour satisfaire toutes les  envies, des petits creux aux grandes faims.','6730c5dcb7bb5.jpg'),(2,'Visite Guid├®e','D├®couvrez nos habitats avec un  guide!\n\nRejoignez-nous pour une aventure fascinante ├á travers notre zoo. Accompagn├® d un guide expert, vous d├®couvrirez les secrets de nos animaux et leurs habitats. Apprenez des anecdotes surprenantes et observez de pr├¿s les comportements uniques de chaque esp├¿ce.','670e36d532953.jpg'),(3,'Safari-train','Bienvenue ├á bord du Safari-Train!\r\n\r\nEmbarquez pour une aventure inoubliable ├á travers les vastes ├®tendues du parc. Confortablement install├® dans notre train, vous aurez lÔÇÖoccasion dÔÇÖobserver de pr├¿s une multitude dÔÇÖanimaux fascinants. NÔÇÖoubliez pas votre appareil photo pour capturer ces moments magiques.','672e39c474d97.jpg');

UNLOCK TABLES;

-- Table structure for table `users`

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role` (`id_role`),
  CONSTRAINT `fk_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `users`

LOCK TABLES `users` WRITE;

INSERT INTO `users` VALUES (1,'Marchand','Jose','jose@hotmail.fr','$2y$10$xDSMbkN8l8uRusXxTjZ06.YTG9rBiYQVI1etHza9D5X1xElVeq80m',1),(11,'Dupont','Claudette','claudette@hotmail.fr','$argon2i$v=19$m=65536,t=4,p=1$TFoxY2xnTVBBZFRqeGNRZA$b/W3sE1rd6oIm9EqiFiBqR293hEJQWqAfb7E+SWrTb4',3),(12,'Bernard','Paul','paul@hotmail.fr','$argon2i$v=19$m=65536,t=4,p=1$Rm9xSjJKQk1tTm5YTmxxaw$1Ni1MhtMhZ4535M0W6ki4MDm+dVpgrsF7laAbAvLlP0',2);

UNLOCK TABLES;


