<?php
    //On démarre la session
    session_start();

    require_once "db.php";

    //On vérifie si on reçoit un ID de la part de blog.php
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        //ICI je n'ai pas d'ID, je redirige vers 404.php
        http_response_code(404);
        header("Location: 404.php");
        exit();
    }

    //On stock l'id du post qu'on souhaite afficher
    $id = $_GET['id'];

    //On prépare la requête pour récupérer le film
    $sql = "SELECT * FROM `movie` WHERE `movie_id` = ?";
    $req = $db->prepare($sql);
    $req->bindValue(1, $id, PDO::PARAM_INT);
    $req->execute();
    $movie = $req->fetch();

    //On prépare la requête pour récupérer le post
    $sql = "SELECT * FROM `posts` WHERE `movie_id` = ?";
    $req = $db->prepare($sql);
    $req->bindValue(1, $id, PDO::PARAM_INT);
    $req->execute();
    // $posts = $req->fetch();
    $posts = $req->fetchAll(PDO::FETCH_OBJ);  

    //RECUPERE LES GENRES DE LA TABLE FILM POUR LES LIER A LA TABLE DES GENRES
    $genre_ids = [
    $movie->genre1,
    $movie->genre2,
    $movie->genre3
    ];
    //On prépare la requête pour récupérer le(s) genre(s)
    $sql = "SELECT * FROM genre WHERE `genre_id` IN  (?, ?, ?)";
    // $req = $db->query($sql);
    // $genre = $req->fetch();
    $req = $db->prepare($sql);
    $req->execute($genre_ids);
    $genres = $req->fetchAll(PDO::FETCH_OBJ);

    // //On va chercher le user auteur du post
    // $user_id = $_SESSION["user"]["id"];
    // $sql_user = "SELECT * FROM `posts` WHERE author = $user_id" ;
    // $req = $db->query($sql_user);
    // $user = $req->fetch();

// $postAuthor = $_SESSION["user"]["id"];

    //Selectionner et calculer la moyenne des notes et le nombre de note donnée au film
    $sql = "SELECT AVG(rate) AS average_rate, COUNT(rate) AS rate_count FROM posts WHERE movie_id = ?";
    $req = $db->prepare($sql);
    $req->bindValue(1, $id, PDO::PARAM_INT);
    $req->execute();
    $result = $req->fetch();

    $average = $result->average_rate;
    $count = $result->rate_count;

    //Trouver l'author du post
    function getAuthor($id, $db) {
    $sql = "SELECT * FROM users WHERE users_id = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id, PDO::PARAM_INT);
    $req->execute();
    return $req->fetch();
    }


    //On vérifie que le post existe dans la BDD
    if(!$movie) {
        http_response_code(404);
        header("Location: 404.php");
        exit();
    }

    $title = "CMS || $movie->movie_name";
    include "components/header.php";
    include "components/nav.php";

?>

<!-- Message de confirmation de l'ajout d'un commentaire -->
<?php if(isset($_GET["message"])) : ?>
    <div class="notification is-success m-5" id="notification">
        <button class="delete"></button>
        <p><?= $_GET["message"] ?></p>
    </div>
<?php endif ; ?>

<!-- FICHE DU FILM -->
<section class="is-flex is-flex-wrap-wrap is-justify-content-center m-4">
    <div class="card m-4" style="width: 80%">
        <header class="card-header">
            <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                <h4 class="title is-3"><?= strip_tags($movie->movie_name) ?></h4>
            </div>
        </header>
        <div class="card-content">
            <div class="content">
                <p><strong>Directed by : </strong><?= strip_tags($movie->movie_directorFname) . " " . strip_tags($movie->movie_directorLname) ?></p>

                <p><strong>Release date : </strong><?= $movie->movie_date ?></p>

                <!-- AFFICHAGE DES GENRES -->
                <p><strong>Genre : </strong>
                    <?php foreach ($genres as $genre) {
                    echo " -" . htmlspecialchars($genre->genre);
                    } ?>
                </p>

                <?php if($count === 0) : ?>
                <p>Aucune commentaire</p>
                <?php else : ?>
                <p><strong>Average rate : </strong> <?= round($average, 2); ?>, (<?= $count; ?>) </p>
                <?php endif; ?>

                <?php $author =  getAuthor($movie->movieUser_id, $db)?>
                <p><i>This informations are from : <?= $author->users_fname . " " . $author->users_lname ?></i></p>

            </div>
        </div>

        <footer class="card-footer">
            <?php if(isset ($_SESSION["user"]) && $_SESSION["user"]["id"] === $movie->movieUser_id) :?>
                <a href="updateMovie.php?id=<?= $movie->movie_id?>" class="button is-warning is-light card-footer-item">Modifier</a>
                <a href="deleteMovie.php?id=<?= $movie->movie_id?>" class="button is-danger is-light card-footer-item">Supprimer</a>
                <a class="button is-primary is-light card-footer-item" href="blog.php">Retour</a>
            <?php else: ?>
                <a class="button is-primary is-light card-footer-item" href="blog.php">Retour</a>
            <?php endif; ?>
        </footer>
    </div>
</section>


<!-- COMMENTAIRE DU FILM -->
<section class="is-flex is-flex-wrap-wrap is-justify-content-center m-4">
    <?php foreach ($posts as $post): ?>

    <div class="card m-4" style="width: 60%">
        <header class="card-header">
            <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                <h4 class="title is-3"><?= strip_tags($post->title) ?></h4>
            </div>
        </header>
        <div class="card-content">
            <div class="content">
                <p><strong><?= $post->rate ?>/10</strong></p>
                <p><?= $post->comment ?></p>
            </div>
        </div>
        <div class="card-content">
            <div class="content">
                <?php $author =  getAuthor($post->author, $db)?>
                <p>Auteur.trice :<i> <?= $author->users_fname . " " . $author->users_lname ?></i></p>
            </div>
        </div> 
        <footer class="card-footer">
              <?php  if (isset($_SESSION["user"]) && (int)$_SESSION["user"]["id"] === (int)$post->author):?>

                <a href="updateComment.php?id=<?= $post->posts_id?>" class="button is-warning is-light card-footer-item">Modifier</a>
                <a href="deleteComment.php?id=<?= $post->posts_id?>" class="button is-danger is-light card-footer-item">Supprimer</a>
            <?php endif; ?>
        </footer>       
    </div>
    <?php endforeach; ?>

</section>


            
<?php if(isset($_SESSION["user"])) : ?> 
    <div class="buttons is-centered">
        <a class="button is-primary is-light is-link" href="addComment.php?id=<?= $movie->movie_id?>">Ajouter un commentaire</a>
    </div>
<?php endif; ?>


<?php
include "components/footer.php";
?>
