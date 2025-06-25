<?php
session_start();

    include "components/header.php";
    include "components/nav.php";

    //var_dump($_GET["id"]);


//On vérifie qu'on reçoit un ID de la part de post.php
if(!isset($_GET["id"]) || empty($_GET["id"])) {
    //Ici, je n'ai pas reçu d'id, je redirige l'utilisateur vers la page Blog
    header("Location: blog.php");
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

//On vérifie si l'article est vide
if(!$post) {
    http_response_code(404);
    echo "Désolé, aucun article trouvé";
    exit();
}

$title = "CMS || Modifier $post->posts_title";

//On vérifie si l'article appartient à l'utilisateur
if($_SESSION["user"]["id"] === $post->posts_author) {

    //Ici, l'article appartient bien au user, on peut traiter le formulaire
    if(!empty($_POST)) {
        if(!empty($_POST["title"]) && !empty($_POST["content"])) {
            //Ici, on a un formulaire complet
            //On récupère les infos en les protégeant
            $postTitle = strip_tags($_POST["title"]);
            $postContent = strip_tags($_POST["content"]);
            $author = $post->posts_author;

            //Ici, on peut enregistrer les données
            $sql = "UPDATE posts SET posts_title = :title, posts_content = :content, posts_author = :author WHERE posts_id = :id";
            $req = $db->prepare($sql);
            $req->bindValue(":title", $postTitle);
            $req->bindValue(":content", $postContent);
            $req->bindValue(":author", $author);
            $req->bindValue(":id", $id);

            if(!$req->execute()) {
                http_response_code(500);
                echo "Désolé, quelque chose n'a pas fonctionné";
                exit();
            }
            //Ici, on a un uptade qui a réussi
            header("Location: post.php?id=" .$id);
        }
    }

} else {
    header("Location: post.php?id=" .$id);
}

?>

<section class="hero is-medium is-success has-text-centered">
    <div class="hero-body">
        <p class="title">
            Modifier un article
        </p>
        <p class="subtitle">
            #MaVieEstGénialementCorrigée
            #LikeMonUpdate
        </p>
    </div>
</section>

<section class="section is-flex is-flex-direction-column is-justify-content-center">
    <form method="post">
        <div class="field">
            <label for="title" class="label">Titre</label>
            <div class="control">
                <input class="input" type="text" name="title" value=<?= $post->posts_title ?>>
            </div>
        </div>
        <div class="field">
            <label for="content" class="label">Contenu</label>
            <div class="control">
                <textarea name="content" class="textarea"><?= $post->posts_content ?></textarea>
            </div>
        </div>
        <div class="control">
            <button class="button is-link" type="submit">Modifier mon post</button>
        </div>
    </form>
</section>