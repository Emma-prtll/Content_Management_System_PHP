-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.4.3 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage des données de la table cms_bdd.genre : ~14 rows (environ)
REPLACE INTO `genre` (`genre_id`, `genre`) VALUES
	(1, 'Comedie'),
	(2, 'Romantique'),
	(3, 'Action'),
	(4, 'Suspense'),
	(5, 'Historique'),
	(6, 'Horreur'),
	(7, 'Teen-movie'),
	(8, 'Aventure'),
	(9, 'Casse'),
	(10, 'Noël'),
	(11, 'Thriller'),
	(12, 'Science-fiction'),
	(13, 'Western'),
	(14, 'Comedie Musical');

-- Listage des données de la table cms_bdd.movie : ~9 rows (environ)
REPLACE INTO `movie` (`movie_id`, `movie_name`, `movie_date`, `movie_directorFname`, `movie_directorLname`, `movieUser_id`, `genre1`, `genre2`, `genre3`) VALUES
	(1, 'Titanic', '1997-12-19', 'James', 'Cameron', 21, NULL, NULL, NULL),
	(2, 'The Shawshank Redemption', '1994-09-23', 'Frank', 'Darabont', 3, 4, 5, 11),
	(3, 'Inception', '2010-07-16', 'Christopher', 'Nolan', 4, 1, 7, 6),
	(4, 'Parasite', '2019-05-30', 'Bong', 'Joon-ho', 18, 3, 11, 6),
	(6, 'The Godfather', '1972-03-24', 'Francis', 'Coppola', 2, 10, 3, NULL),
	(9, 'Pulp Fiction', '1994-10-14', 'Quentin', 'Tarantino', 17, 10, 3, NULL),
	(25, 'Spirited Away', '2001-07-20', 'Hayao', 'Miyazaki', 1, 9, 8, 12),
	(26, 'Forrest Gump', '1994-07-06', 'Robert', 'Zemeckis', 18, 3, 4, 5),
	(27, 'La La Land', '2016-12-09', 'Damien', 'Chazelle', 3, 13, 4, 3);

-- Listage des données de la table cms_bdd.posts : ~32 rows (environ)
REPLACE INTO `posts` (`posts_id`, `comment`, `rate`, `title`, `author`, `movie_id`) VALUES
	(1, 'Le début est prometteur, mais la fin m’a un peu déçu.', 6, 'Fin prévisible', '3', 0),
	(2, 'Excellente ambiance, des personnages attachants et une bande‑son superbe.', 8, 'Ambiance réussie', '1', 0),
	(4, 'Le récit se déroule trop lentement, on perd l’attention avant la résolution.', 5, 'Manque de rythme', '21', 1),
	(5, 'Effets spéciaux impressionnants, le scénario tient bien la route et les acteurs sont forts.', 9, 'Spectacle visuel', '1', 2),
	(6, 'J’ai adoré l’humour subtil et les clins d’œil aux comics, vraiment divertissant.', 8, 'Humour bien dosé', '3', 2),
	(7, 'L’histoire vraie est touchante, mais j’aurais aimé plus de profondeur dans les dialogues.', 7, 'Histoire émouvante', '4', 1),
	(8, 'Quelques longueurs, mais les scènes sur l’eau sont magnifiquement filmées.', 7, 'Visuellement beau', '3', 1),
	(9, 'Belles images, mais le scénario manque de substance pour un tel sujet.', 5, 'Image vs contenu', '3', 1),
	(10, 'Un film moyen, on oublie vite après le générique.', 4, 'Oublie rapide', '17', 1),
	(11, 'L’univers est riche et original, hâte de voir la suite.', 8, 'Univers captivant', '18', 2),
	(12, 'La romance est mignonne, mais l’intrigue secondaire est confuse.', 6, 'Romance légère', '17', 1),
	(13, 'Très décevant, je ne comprends pas l’engouement autour de ce titre.', 2, 'Surcoté', '4', 1),
	(14, 'Intriguant au début, devient trop dark sans justification narrative.', 4, 'Trop sombre', '3', 4),
	(15, 'Bonne tentative, mais l’écriture des personnages manque de subtilité.', 5, 'Personnages plats', '4', 4),
	(16, 'L’équilibre action‑émotion est respecté, j’ai passé un bon moment.', 7, 'Bon divertissement', '20', 4),
	(17, 'Le scénario est simple mais efficace, idéal pour une soirée détente.', 7, 'Simple et efficace', '3', 6),
	(18, 'Ambiance un peu froide, je n’ai pas accroché aux protagonistes.', 5, 'Ambiance distante', '17', 6),
	(19, 'Quelques bonnes idées de mise en scène, dommage que le montage soit chaotique.', 6, 'Montage confus', '20', 6),
	(20, 'Acteurs convaincants, mais l’histoire peine à décoller.', 6, 'Bonnes performances', '4', 6),
	(21, 'La photographie est splendide, mais j’attendais plus d’intensité dramatique.', 6, 'Photographie soignée', '3', 6),
	(22, 'Musique envoûtante qui sauve plusieurs scènes un peu longues.', 7, 'Bande‑son immersive', '18', 6),
	(23, 'Le twist final est réussi, j’étais vraiment surpris.', 8, 'Twist maîtrisé', '3', 6),
	(24, 'Un thriller psychologique efficace, on reste scotché jusqu’à la dernière minute.', 9, 'Thriller haletant', '2', 5),
	(25, 'Commentaire constructif : j’aime beaucoup le rythme, mais certains dialogues sonnent faux.', 7, 'Rythme appréciable', '1', 7),
	(26, 'Écriture soignée, personnages profonds, mais un peu long sur la deuxième partie.', 6, 'Deuxième partie lente', '1', 7),
	(27, 'L’univers imaginé est fascinant, j’espère une suite à la hauteur.', 8, 'Univers fascinant', '3', 7),
	(28, 'Ambiance maritime bien rendue, mais le scénario manque de relief.', 5, 'Beaux décors', '17', 1),
	(29, 'Scénario original et portée sociale intéressante.', 8, 'Portrait social', '4', 24),
	(30, 'La mise en scène est fluide, mais j’ai trouvé la fin un peu expédiée.', 6, 'Fin précipitée', '3', 12),
	(31, 'Dialogues parfois lourds, mais l’intention est louable.', 5, 'Intentions louables', '1', 11),
	(32, 'Acteurs charismatiques, mais le scénario manque d’ambition.', 6, 'Charisme seul', '2', 10),
	(33, 'Un chef‑d’œuvre moderne, chaque plan est une œuvre d’art.', 10, 'Chef‑d’œuvre', '18', 3);

-- Listage des données de la table cms_bdd.users : ~8 rows (environ)
REPLACE INTO `users` (`users_id`, `users_fname`, `users_lname`, `users_email`, `users_password`) VALUES
	(1, 'Marie', 'Dupont', 'marie.dupont@example.com', '1234'),
	(2, 'Alice', 'Martin', 'alice.martin@example.com', '$argon2i$v=19$m=65536,t=4,p=1$ZlVsMTNKMmZybXh1enA5WA$HuWsGudiIOag/TtwTfloYJ+UQGkNERjc1NT3Wn3IeRI'),
	(3, 'John', 'Doe', 'john.doe@example.com', '$argon2i$v=19$m=65536,t=4,p=1$MDZ2RVA3azcxcFYxOWdjNQ$ZzbOXHI2/2g8Nh1b+F2sFyCzJ8qQ77pdEAct4oeq0GA'),
	(4, 'Chloé', 'Bernard', 'chloe.bernard@example.com', '$argon2i$v=19$m=65536,t=4,p=1$RE5tNXppODNmSGYwTmY4bQ$lcDvZ24oCqIkieKDLYemck08p4/p0ibIdOEK+SKmZv0'),
	(17, 'Julien', 'Moreau', 'julien.moreau@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$aU5oaENVUFRWR3pvVzE2bQ$lK8UVgKu5qCITJ7bEwdFsJsSQCV7/BGOHqg3TnoiafY'),
	(18, 'Marta', 'Schaf', 'maroussia.schaffner@bluewin.ch', '$argon2i$v=19$m=65536,t=4,p=1$WFAyczhkbzdFYjJXc1NmbA$0QtPE7OIvCd5PXwpdlFxkjHqzKH02zV47BJxKWKEE0I'),
	(20, 'Laura', 'Gauthier', 'laura.gauthier@example.com', '$argon2i$v=19$m=65536,t=4,p=1$dFAydDFuNWluQW9XMFd4Mw$HPDo1G6LeJoZvJVrB/tDak4fOX2VSudmeGVGtCAlrlA'),
	(21, 'Emma', 'Portillo', 'emma.portillo@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$NWVYLm1GTFBkQjRjTU1EMA$gdLnfBdZ5vLuHwo+a7gI0T4a7wxlHjliz7EVskQHLYc');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
