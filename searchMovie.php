<?php
//On démarre la session
session_start();

//On se connecte à notre BDD
require_once "db.php";

//Changement du title de la page
$title = "CMS - Recherche";

//Intégration du header et de la navigation
include "components/header.php";
include "components/nav.php";

// On initialise $results pour éviter les erreurs plus bas
$results = [];
$found = 0;

if (!empty($_POST) && isset($_POST["search"]) && !empty(trim($_POST["search"]))) {
    // Nettoyage du champ de recherche
    $search = trim($_POST["search"]);

    //On prépare la requête pour récupérer le film
    $sql = "SELECT * FROM `movie` WHERE `movie_name` LIKE ?";
    $req = $db->prepare($sql);
    $req->execute(["%$search%"]);
    $results = $req->fetchAll(PDO::FETCH_OBJ);

    if (count($results) > 0) {
        $found = 2;
        //  echo "<p>Films trouvés :</p>";
        //  foreach ($results as $movie) {
        //      echo "<p>" . htmlspecialchars($movie->movie_name) . "</p>";
        //  }
    } else {
        $found = 1;
        //  echo "<p>Aucun résultat trouvé.</p>";
    }
}
?>

<section style="display: flex; justify-content: center" class="my-6">
    <form method="post" style="width: 50%">
        <div class="field">
            <label class="label" for="search">Rechercher un film</label>
            <div class="control">
                <input class="input" type="text" name="search" id="search" placeholder="Le nom du film" value="<?= isset($search) ? htmlspecialchars($search) : '' ?>">
            </div>
        </div>
        <button type="submit" class="button is-primary">Rechercher</button>
    </form>
</section>


<?php if($found === 2):?>
    <section style="display: flex; justify-content: center" class="my-6">
        <?php foreach ($results as $movie): ?>
            <div class="card m-4" style="width: 40%">
                <header class="card-header">
                    <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                        <h4 class="title is-3"><?= strip_tags(htmlspecialchars($movie->movie_name)) ?></h4>
                    </div>
                </header>
                <footer class="card-footer">
                        <a href="movie.php?id=<?= $movie->movie_id?>" class="button is-warning is-light card-footer-item">Voir le post</a>
                </footer> 
            </div>
        <?php endforeach; ?>
    </section>
    <?php if(isset($_SESSION["user"])) : ?> 
        <section style="display: flex; justify-content: center">
            <a href="addMovie.php" class="button is-warning is-light my-6" style="width: 20%">Ajouter un post</a>
        </section>
    <?php endif; ?>

<?php elseif($found === 1):?>
    <section style="display: flex; justify-content: center">
        <p class="is-warning is-light my-6">Aucun resultat trouvé</p>
    </section>

    <?php if(isset($_SESSION["user"])) : ?> 
        <section style="display: flex; justify-content: center">
            <a href="addMovie.php" class="button is-warning is-light my-6" style="width: 20%">Ajouter un post</a>
        </section>
    <?php endif; ?>
    
<?php else:?>
    <p></p>
<?php endif;?>






<?php
include "components/footer.php";
?>
