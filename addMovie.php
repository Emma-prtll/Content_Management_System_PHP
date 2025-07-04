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
    if(isset($_POST["name"], $_POST["date"], $_POST["directorFname"], $_POST["directorLname"]) && !empty($_POST["name"]) && !empty($_POST["date"]) && !empty($_POST["directorFname"]) && !empty($_POST["directorLname"])){
        //Ici, le formulaire est rempli. Titre et contenu ne sont pas vide

        //On récupère les infos et on les protège et on supprime les potentielles espaces au début et à la fin des noms avec trim()
        $movieName = strip_tags(trim($_POST['name']));
        $movieDate = strip_tags($_POST['date']);
        $movieDirectorFname = strip_tags(trim($_POST['directorFname']));
        $movieDirectorLname = strip_tags(trim($_POST['directorLname']));
        $movieAuthor = $_SESSION["user"]["id"];


        //On vérifie l'entrée dans prénom et nom, si ce n'est pas correcte, erreur devient true et le reste du scripte ne sera pas effectué.        
        $erreur = false;
        //On vérifie que le prénom et le nom ne contienne pas de chiffre, ou autre caractère non-utilisable
        $regex = "/^[\p{L} '-]+$/u";
        if (!preg_match($regex, $movieDirectorFname) || !preg_match($regex, $movieDirectorLname)) {
            $messageErreur = "Le nom et le prénom doivent contenir uniquement des lettres.";
            $erreur = true;
        }

        if(!$erreur){
        // Récupération des genres sélectionnés (1 à 3)
        $selectedGenres = $_POST['genres'] ?? [];

        $genre1 = $selectedGenres[0] ?? null;
        $genre2 = $selectedGenres[1] ?? null;
        $genre3 = $selectedGenres[2] ?? null;


        
        // On force la première lettre en majuscule et les autres en minuscules (en UTF-8)
        $movieDirectorFname = mb_convert_case($movieDirectorFname, MB_CASE_TITLE, "UTF-8");
        $movieDirectorLname = mb_convert_case($movieDirectorLname, MB_CASE_TITLE, "UTF-8");

      
        //Requête SQL préparée car ces données viennent du user (POST = requête préparée)
        $sql = "INSERT INTO `movie` (`movie_name`, `movie_date`, `movie_directorFname`, `movie_directorLname`, `movieUser_id`, `genre1`, `genre2`, `genre3`) VALUES (:name, :date, :directorFname, :directorLname, :movieUser, :genre1, :genre2, :genre3)";
        $req = $db->prepare($sql);
        $req->bindValue(":name", $movieName, PDO::PARAM_STR);
        $req->bindValue(":date", $movieDate, PDO::PARAM_STR);
        $req->bindValue(":directorFname", $movieDirectorFname, PDO::PARAM_STR);
        $req->bindValue(":directorLname", $movieDirectorLname, PDO::PARAM_STR);
        $req->bindValue(":movieUser", $movieAuthor, PDO::PARAM_INT);
        $req->bindValue(":genre1", $genre1, PDO::PARAM_INT);
        $req->bindValue(":genre2", $genre2, PDO::PARAM_INT);
        $req->bindValue(":genre3", $genre3, PDO::PARAM_INT);
        //On exécute la requête qui est protégée
        if(!$req->execute()){
            http_response_code(500);
            echo "Désolé, quelque chose n'a pas fonctionné";
            exit();
        }

        //On récupère l'article de l'id qu'on vient de crée
        $id = $db->lastInsertId();
        //On a bien enregister le nouveau post
        //On redirige l'utilisateur vers le blog et on passe un message a blog.php
        $message = urlencode("Bravo, votre nouvel article a bien été créé.");
        header("Location: blog.php?message=".$message);
        }
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


<style>
  .tag.selected {
    background-color:rgb(92, 0, 167) !important;
    color: white !important;
  }

  .tag.disabled {
    opacity: 0.5;
    pointer-events: none;
  }
</style>

<?php if (!empty($messageErreur)): ?>
    <div class="notification is-danger m-5">
        <p><?= htmlspecialchars($messageErreur) ?></p>
    </div>
<?php endif; ?>

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
                <input type="text" class="input" name="directorFname" placeholder="Prénom"> 
            </div>  
            <div class="control">
                <input type="text" class="input" name="directorLname" placeholder="Nom">
            </div>  
        </div>

        <div class="field">
        <label class="label">Genres du film (1 à 3 max)</label>
        <div class="tags are-medium" id="genre-container">
            <?php foreach ($genres as $genre): ?>
            <label class="tag is-dark check-label">
                <input type="checkbox" class="genre-checkbox" name="genres[]" value="<?= $genre->genre_id ?>" hidden>
                <?= htmlspecialchars($genre->genre) ?>
            </label>
            <?php endforeach; ?>
        </div>
        </div>  

        <div class="control mt-5">
            <button class="button is-link" type="submit">Poster l'article</button>
        </div>
    </form>
</section>

<?php
//Intégration du footer à la page index
include "components/footer.php";
?>