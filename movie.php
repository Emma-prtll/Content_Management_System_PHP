<?php
    //On démarre la session
    session_start();

    require_once "db.php";

    //On vérifie si on reçoit un ID de la part de blog.php
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        //ICI je n'ai pas d'ID, je redirige vers Blog.php
        header('Location: blog.php');
        exit();
    }

    //On stock l'id du post qu'on souhaite afficher
    $id = $_GET['id'];

    //On prépare la requête pour récupérer le post
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
    $posts = $req->fetch();

    //On va chercher le user auteur du post
    $user_id = $_SESSION["user"]["id"];
    $sql_user = "SELECT * FROM `posts` WHERE author = $user_id" ;
    $req = $db->query($sql_user);
    $user = $req->fetch();




    //On vérifie que le post existe dans la BDD
    if(!$movie) {
        http_response_code(404);
        echo "Désolé, cet article n'existe pas";
        exit();
    }

    $title = "CMS || $movie->movie_name";
    include "components/header.php";
    include "components/nav.php";

?>

<section class="is-flex is-flex-wrap-wrap is-justify-content-center m-4">
    <div class="card m-4" style="width: 80%">
        <header class="card-header">
            <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                <h4 class="title is-3"><?= strip_tags($movie->movie_name) ?></h4>
            </div>
        </header>
        <div class="card-content">
            <div class="content">
                <p><strong>Directed by : </strong><?= strip_tags($movie->movie_director) ?></p>
                <p><strong>Release date : </strong><?= $movie->movie_date ?></p>

                <!-- <p>The information are from : <a href="#"><i> <?= $user->users_fname . " " . $user->users_lname ?></i></a></p> -->
            </div>
        </div>
        <footer class="card-footer">
            <a class="button is-primary is-light card-footer-item" href="blog.php">Retour</a>
        </footer>
    </div>
</section>



<section class="is-flex is-flex-wrap-wrap is-justify-content-center m-4">

    <div class="card m-4" style="width: 60%">
        <header class="card-header">
            <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                <h4 class="title is-3"><?= strip_tags($posts->title) ?></h4>
            </div>
        </header>
        <div class="card-content">
            <div class="content">
                <p><strong><?= $posts->rate ?>/10</strong></p>
                <p><?= nl2br(htmlspecialchars($posts->comment)) ?></p>
            </div>
        </div>
        <div class="card-content">
            <div class="content">
                <p>Author : <?= $user->users_fname . " " . $user->users_lname ?></p>
            </div>
        </div>        
    </div>

</section>


<div class="buttons is-centered">
    <a class="button is-primary is-light is-link" href="addPost.php?id=<?= $movie->movie_id?>">Ajouter un commentaire</a>
</div>


<?php
include "components/footer.php";
?>
