<?php
//On démarre la session
session_start();

//Pour ne pas qu'on puisse avoir acces à la page addComment depuis la barre de recherche sans être connecter
if(!isset($_SESSION["user"])) {
    header("Location: index.php");
}

//On vérifie si on reçoit un ID de la part de movie.php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    //ICI je n'ai pas d'ID, je redirige vers 404.php
    http_response_code(404);
    header("Location: 404.php");
    exit();
}

//On stock l'id du post qu'on souhaite afficher
$movie_id = $_GET['id'];

//On traite le formulaire
if(!empty($_POST)) {
    if(isset($_POST["title"], $_POST["content"], $_POST["rate"]) && !empty($_POST["title"]) && !empty($_POST["content"]) && !empty($_POST["rate"])){
        //Ici, le formulaire est rempli. Titre et contenu ne sont pas vide

        //On récupère les infos et on les protège
        $postTitle = strip_tags($_POST['title']);
        $postContent = strip_tags($_POST['content']);
        $postRate = strip_tags($_POST['rate']);
        $postAuthor = $_SESSION["user"]["id"];


        //On peut enregistrer les données en BDD
        //On se connect à la BDD
        require_once "db.php";

        //Requête SQL préparée car ces données viennent du user (POST = requête préparée)
        $sql = "INSERT INTO `posts` (`comment`, `rate`, `title`, `author`, `movie_id`) VALUES (:comment, :rate, :title, :author, :movie_id)";
        //On prépare la requête
        $req = $db->prepare($sql);
        //On bind les values
        $req->bindValue(":comment", $postContent, PDO::PARAM_STR);
        $req->bindValue(":rate", $postRate, PDO::PARAM_INT);
        $req->bindValue(":title", $postTitle, PDO::PARAM_STR);
        $req->bindValue(":author", $postAuthor, PDO::PARAM_INT);
        $req->bindValue(":movie_id", $movie_id, PDO::PARAM_INT);
        //On exécute la requête qui est protégée
        if(!$req->execute()){
            http_response_code(500);
            echo "Désolé, quelque chose n'a pas fonctionné";
            exit();
        }

        //On récupère l'article de l'id qu'on vient de crée
        $id = $db->lastInsertId();
        //On a bien enregister le nouveau post
        //On redirige l'utilisateur vers la page du film et on passe un message a movie.php
        $message = urlencode("Bravo, votre commentaire a bien été créé.");
        // header("Location: movie.php?message=".$message);
        header("Location: movie.php?id=" . $movie_id . "&message=" . $message);




    } else {
        //Ici, soit le formulaire est vide, soit le champ titre ou contenu est vide
        $messageErreur = "Le formulaire est incomplet.";
    }
}


$title = "CMS|| Ajouter un commetaire";
//Integration des du header et de la navbar à la page index
include "components/header.php";
include "components/nav.php";

//Tester si on récupère bien les infos du formulaire avant de faire le lien avec la BDD
//var_dump($_POST);

?>
<?php if (!empty($messageErreur)): ?>
    <div class="notification is-danger m-5">
        <p><?= htmlspecialchars($messageErreur) ?></p>
    </div>
<?php endif; ?>

<section class="section is-flex is-flex-direction-column is-justify-content-center">
    <form method="post">
        <div class="field">
            <label class="label" for="title">
                Titre
            </label>
            <div class="control">
                <input type="text" class="input" name="title" placeholder="Le titre de l'article ">
            </div>      
        </div>
        
        <div class="field">
            <label class="label" for="content">
                Contenu
            </label>
            <div class="control">
                <textarea name="content" class="textarea" placeholder="Contenu de l'article "></textarea>
            </div>             
        </div>

        <div class="field">
            <label for="rate">Note du film :</label>
            <input type="number" id="rate" name="rate" min="0" max="10" />            
        </div>

        <div class="control">
            <button class="button is-link" type="submit">Poster l'article</button>
        </div>


    </form>
</section>

<?php
//Intégration du footer à la page index
include "components/footer.php";
?>