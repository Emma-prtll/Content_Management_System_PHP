<?php
//On démarre la session
session_start();

//Pour ne pas qu'on puisse avoir acces à la page addPost depuis la barre de recherche sans être connecter
if(!isset($_SESSION["user"])) {
    header("Location: index.php");
}

//On se connect à la BDD
require_once "db.php";

$sql = "SELECT * FROM genre";
$req = $db->query($sql);
$genres = $req->fetchAll();

//On traite le formulaire
if(!empty($_POST)) {
    if(isset($_POST["name"], $_POST["date"], $_POST["director"]) && !empty($_POST["name"]) && !empty($_POST["date"]) && !empty($_POST["director"])){
        //Ici, le formulaire est rempli. Titre et contenu ne sont pas vide

        //On récupère les infos et on les protège
        $movieName = strip_tags($_POST['name']);
        $movieDate = strip_tags($_POST['date']);
        $movieDirector = strip_tags($_POST['director']);
        $movieAuthor = $_SESSION["user"]["id"];
      
        //Requête SQL préparée car ces données viennent du user (POST = requête préparée)
        $sql = "INSERT INTO `movie` (`movie_name`, `movie_date`, `movie_director`, `movieUser_id`) VALUES (:name, :date, :director, :movieUser)";
        $req = $db->prepare($sql);
        $req->bindValue(":name", $movieName, PDO::PARAM_STR);
        $req->bindValue(":date", $movieDate, PDO::PARAM_STR);
        $req->bindValue(":director", $movieDirector, PDO::PARAM_STR);
        $req->bindValue(":movieUser", $movieAuthor, PDO::PARAM_INT);
        //On exécute la requête qui est protégée
        if(!$req->execute()){
            die("Une erreur est survenue dans l'envoie du formulaire");
        }

        //On récupère l'article de l'id qu'on vient de crée
        $id = $db->lastInsertId();
        //On a bien enregister le nouveau post
        //On redirige l'utilisateur vers le blog et on passe un message a blog.php
        $message = urlencode("Bravo, votre nouvel article a bien été créé.");
        header("Location: blog.php?message=".$message);
                //die("Votre article à bien été ajouté avec l'ID $id ! ");

    } else {
        //Ici, soit le formulaire est vide, soit le champ titre ou contenu est vide
        die("Le formulaire est incomplet");
    }
}


$title = "CMS|| Ajouter un commetaire";
//Integration des du header et de la navbar à la page index
include "components/header.php";
include "components/nav.php";

//Tester si on récupère bien les infos du formulaire avant de faire le lien avec la BDD
//var_dump($_POST);

?>

<section class="section is-flex is-flex-direction-column is-justify-content-center" style="width: 80%">
    <form method="post">
        <div class="field">
            <label class="label" for="name">Nom</label>
            <div class="control">
                <input type="text" class="input" name="name" placeholder="Le nom du film">
            </div>      
        </div>
        
        <div class="field">
            <label class="label" for="date">
                Date de sortie
            </label>
            <div class="control">
                <input name="date" class="input" type="date" placeholder="La date de sortie du film"></input>
            </div>             
        </div>

        <div class="field">
            <label class="label" for="director">Réalisateur.trice</label>
            <div class="control">
                <input type="text" class="input" name="director" placeholder="Qui a réalisé le film">
            </div>      
        </div>

        <div class="field is-grouped is-grouped-multiline">
            <label class="label" for="genre">Genre du film</label>
            <?php foreach ($genres as $genre): ?>
                <p class="control">
                    <button class="button">
                        <?= htmlspecialchars($genre->genre) ?>
                    </button>
                </p>        
            <?php endforeach; ?>
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