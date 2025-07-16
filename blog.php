<?php
//On démarre la session
session_start();

require_once "db.php";



//On fait notre requête pour obtenir tous les posts
$sql = "SELECT * FROM movie";
//Données non sensibles, donc requête non préparée
$req = $db->query($sql);
$movies = $req->fetchAll();

$title = "Blog";
//Integration des du header et de la navbar à la page
include "components/header.php";
include "components/nav.php";

?>

<!-- Affichage du message de confirmation envoyer par addMovie.php ou deleteMovie.php s'il n'est pas vide, donc s'il existe -->
<?php if(isset($_GET["message"])) : ?>
    <div class="notification is-success m-5" id="notification">
        <button class="delete"></button>
        <p><?= $_GET["message"] ?></p>
    </div>
<?php endif ; ?>

<!-- Fiche du film -->
<section class="is-flex is-flex-wrap-wrap is-justify-content-center m-4">
    <?php foreach ($movies as $movie): ?>
        <div class="card m-4" style="width: 30%">

            <header class="card-header">
                <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                    <p class="title is-4"><?= strip_tags($movie->movie_name) ?></p>
                </div>
            </header>

            <div class="card-content">
                <div class="content">
                    <p><strong>Réalisateur.trice : </strong><?= strip_tags($movie->movie_directorFname) . " " . strip_tags($movie->movie_directorLname) ?></p>
                    <p><strong>Date de sortie : </strong><?= strip_tags($movie->movie_date) ?></p>
                </div>
            </div>
            
            <footer class="card-footer"> 
                <!-- Récupère l'id du film pour l'ouvrir sur la page movie.php -->
                <a class="button is-primary is-light card-footer-item" href="movie.php?id=<?= $movie->movie_id ?>">Voir les avis</a>
            </footer> 

        </div>
    <?php endforeach; ?>
</section>

<?php
//Intégration du footer à la page 
include "components/footer.php";
?>
