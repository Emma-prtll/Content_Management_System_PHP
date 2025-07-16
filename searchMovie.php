<?php
//On démarre la session
session_start();

//On se connecte à notre BDD
require_once "db.php";

//On initialise $resultsMovie et $resultsDirector pour éviter les erreurs plus bas 
$resultsMovie = [];
$resultsDirector = [];

//On indique que $found est égale à 0 pour que rien se s'affiche, la valeur de la variable permet de changer l'affichage 
$found = 0;

//On traite le formulaire de la recherche par nom de film
if (!empty($_POST) && isset($_POST["searchMovie"]) && !empty(trim($_POST["searchMovie"]))) {
    //Ici, le formulaire est rempli

    //Nettoyage du champ de recherche
    $searchMovie = trim($_POST["searchMovie"]);

    //On prépare la requête pour récupérer le.s film.s
    $sql = "SELECT * FROM `movie` WHERE `movie_name` LIKE ?";
    $req = $db->prepare($sql);
    $req->execute(["%$searchMovie%"]);
    $resultsMovie = $req->fetchAll(PDO::FETCH_OBJ);

    if (count($resultsMovie) > 0) {
        //S'il y a au moins 1 résultat, alors $found prend la valeur de deux
        $found = 2;
    } else {
        //Autrement, $found prend la valeur de 1, ce qui veut dire que aucun film n'a été trouver
        $found = 1;
    }
}

//On traite le formulaire de la recherche par nom de famille du réalisateur ou de la réalisatrice
if (!empty($_POST) && isset($_POST["searchDirector"]) && !empty(trim($_POST["searchDirector"]))) {
    //Ici, le formulaire est rempli

    // Nettoyage du champ de recherche
    $searchDirector = trim($_POST["searchDirector"]);

    //On prépare la requête pour récupérer le.s film.s
    $sql = "SELECT * FROM `movie` WHERE `movie_directorLname` LIKE ?";
    $req = $db->prepare($sql);
    $req->execute(["%$searchDirector%"]);
    $resultsDirector = $req->fetchAll(PDO::FETCH_OBJ);

    if (count($resultsDirector) > 0) {
        //S'il y a au moins 1 résultat, alors $found prend la valeur de deux
        $found = 2;
    } else {
        //Autrement, $found prend la valeur de 1, ce qui veut dire que aucun film n'a été trouver
        $found = 1;
    }
}

$title = "Recherche d'un film";
//Integration des du header et de la navbar à la page
include "components/header.php";
include "components/nav.php";

?>

<!-- Texte informatif sur la page -->
<section class="has-text-centered mt-6 pb-6">
    <h3 class="title is-3">Rechercher un film afin de savoir si quelqu'un en a déjà parlé !</h3>
    <h3 class="subtitle  is-3">Veuillez indiquer le nom du film ou le <strong>nom de famille</strong> du réalisateur ou de la réalisatrice !</h3>
    <h4 class="subtitle  is-4"><i>Si la fiche du film existe déjà, laisse-y un commentaire, sinon on te laisse prendre le soin de créer la fiche du film !</i></h4>
</section>

<section style="display: flex" class="is-justify-content-space-evenly pb-6">

<!-- Formulaire de recherche par nom de film -->
    <div class="box my-6" style="width: 40%;">
    <form method="post">
        <div class="field">
            <label class="label" for="searchMovie">Rechercher un film</label>
            <div class="control">
                <input class="input" type="text" name="searchMovie" id="searchMovie" placeholder="Le nom du film" value="<?= isset($searchMovie) ? htmlspecialchars($searchMovie) : '' ?>">
            </div>
        </div>
        <button type="submit" class="button is-primary">Rechercher</button>
    </form>
    </div>

<!-- Formulaire de recherche par nom du réalisateur ou de la réalisatrice -->
    <div class="box my-6" style="width: 40%;">
    <form method="post">
        <div class="field">
            <label class="label" for="searchDirector">Rechercher par réalisateur.trice</label>
            <div class="control">
                <input class="input" type="text" name="searchDirector" id="searchDirector" placeholder="Le nom de famille" value="<?= isset($searchDirector) ? htmlspecialchars($searchDirector) : '' ?>">
            </div>
        </div>
        <button type="submit" class="button is-primary">Rechercher</button>
    </form>
    </div>

</section>

<!-- Affichage des résultats -->
<?php if($found === 2):?>
<!-- Si $found vaut 2, alors il y a au moins un résultat à afficher -->
    <section style="display: flex; justify-content: center" class="my-6 is-flex-wrap-wrap">
        <?php foreach ($resultsMovie as $movie): ?>
            <div class="card m-4" style="width: 40%">
                <header class="card-header">
                    <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                        <h4 class="title is-3"><?= strip_tags(htmlspecialchars($movie->movie_name)) ?></h4>
                    </div>
                </header>
                <div class="card-content">
                    <div class="content">
                        <p><strong><?= $movie->movie_directorFname .  " " . $movie->movie_directorLname ?></strong></p>
                    </div>
                </div>                
                <footer class="card-footer">
                        <a href="movie.php?id=<?= $movie->movie_id?>" class="button is-warning is-light card-footer-item">Voir le post</a>
                </footer> 
            </div>
        <?php endforeach; ?>
        <?php foreach ($resultsDirector as $movie): ?>
            <div class="card m-4" style="width: 40%">
                <header class="card-header">
                    <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                        <h4 class="title is-3"><?= strip_tags(htmlspecialchars($movie->movie_name)) ?></h4>
                    </div>
                </header>
                <div class="card-content">
                    <div class="content">
                        <p><strong><?= $movie->movie_directorFname .  " " . $movie->movie_directorLname ?></strong></p>
                    </div>
                </div>                
                <footer class="card-footer">
                        <a href="movie.php?id=<?= $movie->movie_id?>" class="button is-warning is-light card-footer-item">Voir le post</a>
                </footer> 
            </div>
        <?php endforeach; ?>        
    </section>

    <?php if(isset($_SESSION["user"])) : ?> 
    <!-- Si la session de l'utilisateur est ouverte, on lui permet d'ajouter une fiche de film -->
        <section style="display: flex; justify-content: center">
            <a href="addMovie.php" class="button is-warning is-light my-6" style="width: 20%">Ajouter un post</a>
        </section>
    <?php endif; ?>

<?php elseif($found === 1):?>
<!-- Si $found vaut 1, alors il faut indiquer qu'il n'y a pas de résultat trouvé -->
    <section style="display: flex; justify-content: center">
        <p class="is-warning is-light my-6">Aucun resultat trouvé</p>
    </section>

    <?php if(isset($_SESSION["user"])) : ?> 
    <!-- Si la session de l'utilisateur est ouverte, on lui permet d'ajouter une fiche de film -->
        <section style="display: flex; justify-content: center">
            <a href="addMovie.php" class="button is-warning is-light my-6" style="width: 20%">Ajouter un post</a>
        </section>
    <?php endif; ?>
    
<?php else:?>
<!-- Autrement c'est comme si $found vaut 0, ça veut dire qu'il ne faut rien afficher car il n'y pas eu de recherche ou la recherche était vide -->
<?php endif;?>

<?php
//Intégration du footer à la page 
include "components/footer.php";
?>
