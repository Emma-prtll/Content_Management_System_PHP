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
	(1, 'comedy'),
	(2, 'romantic'),
	(3, 'action'),
	(4, 'suspense'),
	(5, 'historic'),
	(6, 'horror'),
	(7, 'teen-movie'),
	(8, 'adventure'),
	(9, 'heist'),
	(10, 'holidays'),
	(11, 'thriller'),
	(12, 'science-fiction'),
	(13, 'western'),
	(14, 'musical');

-- Listage des données de la table cms_bdd.movie : ~5 rows (environ)
REPLACE INTO `movie` (`movie_id`, `movie_name`, `movie_date`, `movie_director`, `movieUser_id`) VALUES
	(1, 'Titanic', '2025-06-12', 'moi', NULL),
	(2, 'X-men Apocalypse', '2023-06-18', 'DiCaprio', NULL),
	(3, 'film 3', '2025-05-27', 'veev', 4),
	(4, 'film 4', '2025-05-27', 'patate', 3),
	(5, 'dw', '2025-05-29', 'wqd', 3);

-- Listage des données de la table cms_bdd.posts : ~15 rows (environ)
REPLACE INTO `posts` (`posts_id`, `comment`, `rate`, `title`, `author`, `movie_id`) VALUES
	(1, 'Lorem', 3, 'ouioui', NULL, 0),
	(2, 'je trouve se filme vriament bienje trouve se filme vriament bienje trouve se filme vriament bienje trouve se filme vriament bienje trouve se filme vriament bienje trouve se filme vriament bien', 5, 'c\'est au top !', NULL, 0),
	(3, 'rhfwfiowefhnwioebfiowbenvoiwèe', 2, 'ewfe', '3', 2),
	(4, 'c\'est juste un bateau qui coule', 5, 'c\'est sur un bateau', '3', 1),
	(5, 'oui c\'est vrm bien ', 9, 'les x-men c\'est top', '3', 2),
	(6, 'j\'aime beaucoup les x-men', 6, 'les x-men c\'est super', '3', 2),
	(7, 'C\'est une histoire vrai', 3, 'c\'est sur le Titanic', '4', 1),
	(8, 'sur l\'eau', 3, 'bateau', '3', 1),
	(9, 'boat boat', 2, 'boat', '3', 1),
	(10, 'vew', 3, 'wve', '3', 1),
	(11, 'wfwfwf', 2, 'x-men', '3', 2),
	(12, 'anic', 2, 'tit', '3', 1),
	(13, 'w', 1, 'w', '3', 1),
	(14, 'wdqw', 2, 'wqd', '3', 4),
	(15, 'd', 2, 'd', '3', 4);

-- Listage des données de la table cms_bdd.users : ~4 rows (environ)
REPLACE INTO `users` (`users_id`, `users_fname`, `users_lname`, `users_email`, `users_password`) VALUES
	(1, 'Emma', 'Portillo', 'emma.portillo03@gmail.com', '1234'),
	(2, 'test', 'test', 'test.test@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$ZlVsMTNKMmZybXh1enA5WA$HuWsGudiIOag/TtwTfloYJ+UQGkNERjc1NT3Wn3IeRI'),
	(3, 'user', 'user', 'user@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$MDZ2RVA3azcxcFYxOWdjNQ$ZzbOXHI2/2g8Nh1b+F2sFyCzJ8qQ77pdEAct4oeq0GA'),
	(4, 'Ma', 'Em', 'EmMA@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$RE5tNXppODNmSGYwTmY4bQ$lcDvZ24oCqIkieKDLYemck08p4/p0ibIdOEK+SKmZv0');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
