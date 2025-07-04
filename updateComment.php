<?php
session_start();

    include "components/header.php";
    include "components/nav.php";

    //var_dump($_GET["id"]);


//On vérifie qu'on reçoit un ID de la part de post.php
if(!isset($_GET["id"]) || empty($_GET["id"])) {
    //ICI je n'ai pas d'ID, je redirige vers 404.php
    http_response_code(404);
    header("Location: 404.php");
    exit();
}


//Ici, j'ai reçu l'id de l'article. Je l'enregistre dans une variable
$id = $_GET["id"];

//On se connecte à la base de donnée
require_once "db.php";

//On récupère l'article qu'on souhaite modifier dans notre BDD avec son ID
//Ici, je choisi une requête préparée car l'ID provient de l'url, donc publique, donc je sécurise
$sql = "SELECT * FROM posts WHERE posts_id = :id";
$req = $db->prepare($sql);
$req->bindValue(":id", $id, PDO::PARAM_INT);
$req->execute();
$post = $req->fetch();

//On vérifie si l'article appartient à l'utilisateur
if($_SESSION["user"]["id"] === (int)$post->author) {

    //Ici, l'article appartient bien au user, on peut traiter le formulaire
    if(!empty($_POST)) {
        if(isset($_POST["title"], $_POST["content"], $_POST["rate"]) && !empty($_POST["title"]) && !empty($_POST["content"]) && !empty($_POST["rate"])){
            //Ici, on a un formulaire complet
            //On récupère les infos et on les protège
            $postTitle = strip_tags($_POST['title']);
            $postContent = strip_tags($_POST['content']);
            $postRate = strip_tags($_POST['rate']);
            $postAuthor = $_SESSION["user"]["id"];

            //Ici, on peut enregistrer les données
            $sql = "UPDATE posts SET title = :title, comment = :content, rate = :rate  WHERE posts_id = :id";
            $req = $db->prepare($sql);

            $req->bindValue(":title", $postTitle, PDO::PARAM_STR);
            $req->bindValue(":content", $postContent, PDO::PARAM_STR);
            $req->bindValue(":rate", $postRate, PDO::PARAM_INT);
            $req->bindValue(":id", $id, PDO::PARAM_INT);

            if(!$req->execute()) {
                http_response_code(500);
                echo "Désolé, quelque chose n'a pas fonctionné";
                exit();
            }
            //Ici, on a un uptade qui a réussi
            // header("Location: movie.php?id=" .$id);


            $movieId = 
            //On redirige l'utilisateur vers la page du film et on passe un message a movie.php
            $message = urlencode("Vous avez modifier votre commentaire");
            header("Location: movie.php?id=" . $post->movie_id . "&message=" . $message);

        }
    }

} else {
    header("Location: index.php?id=" .$id);
}

?>

<section class="section is-flex is-flex-direction-column is-justify-content-center">
    <form method="post">
        <div class="field">
            <label for="title" class="label">Titre</label>
            <div class="control">
                <textarea name="title" class="textarea"><?= $post->title ?></textarea>
            </div>
        </div>
        <div class="field">
            <label for="content" class="label">Contenu</label>
            <div class="control">
                <textarea name="content" class="textarea"><?= $post->comment ?></textarea>
            </div>
        </div>
        <div class="field">
            <label for="rate" class="label">Note</label>
            <div class="control">
                <input type="number" id="rate" name="rate" min="0" max="10" value="<?= $post->rate ?>"/>            
            </div>
        </div>
        <div class="control">
            <button class="button is-link" type="submit">Modifier mon post</button>
            <a class="button is-danger is-light ml-5" href="movie.php?id=<?= $post->movie_id ?>"><strong>Annuler</strong> </a>
        </div>
    </form>
</section>