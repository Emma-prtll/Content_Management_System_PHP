<?php
//On démarre la session
session_start();

//On se connecte à la base de donnée
require_once "db.php";

//On vérifie qu'on reçoit un ID de la part de movie.php
if(!isset($_GET["id"]) || empty($_GET["id"])) {
    //ICI je n'ai pas d'ID, je redirige vers 404.php
    http_response_code(404);
    header("Location: 404.php");
    exit();
}

//Ici, j'ai reçu l'id de l'article. Je l'enregistre dans une variable
$id = $_GET["id"];

//On récupère l'article qu'on souhaite modifier dans notre BDD avec son ID
//Ici, je choisi une requête préparée car l'ID provient de l'url, donc publique, donc je sécurise
$sql = "SELECT * FROM movie WHERE movie_id = :id";
$req = $db->prepare($sql);
$req->bindValue(":id", $id, PDO::PARAM_INT);
$req->execute();
$movie = $req->fetch();

$sql = "SELECT * FROM genre";
$req = $db->query($sql);
$genres = $req->fetchAll();

//Je stocke les genres sélectionner afin d'alléger mon code pour la suite
$genre_1 = $movie->genre1;
$genre_2 = $movie->genre2;
$genre_3 = $movie->genre3;

//On vérifie si l'article appartient à l'utilisateur
if($_SESSION["user"]["id"] === $movie->movieUser_id) {

    //Ici, l'article appartient bien au user, on peut traiter le formulaire
    if(!empty($_POST)) {
        if(isset($_POST["name"], $_POST["date"], $_POST["directorFname"], $_POST["directorLname"]) && !empty($_POST["name"]) && !empty($_POST["date"]) && !empty($_POST["directorFname"]) && !empty($_POST["directorLname"])){
            //Ici, on a un formulaire complet

            //On récupère les infos en les protégeant et on supprime les potentielles espaces au début et à la fin avec trim()
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
        
            //S'il n'y a pas d'erreur
            if(!$erreur){
                // Si moins de 3 genres séléctionnée, alors la case reste vide (null) 
                $selectedGenres = $_POST['genres'] ?? [];

                $genre1 = $selectedGenres[0] ?? null;
                $genre2 = $selectedGenres[1] ?? null;
                $genre3 = $selectedGenres[2] ?? null;

                // On force la première lettre en majuscule et les autres en minuscules (en UTF-8)
                $movieDirectorFname = mb_convert_case($movieDirectorFname, MB_CASE_TITLE, "UTF-8");
                $movieDirectorLname = mb_convert_case($movieDirectorLname, MB_CASE_TITLE, "UTF-8");

                //Ici, on peut enregistrer les nouvelles données
                $sql = "UPDATE movie SET movie_name = :name, movie_date = :date, movie_directorFname = :directorFname, movie_directorLname = :directorLname, genre1 = :genre1, genre2 = :genre2, genre3 = :genre3 WHERE movie_id = :id";
                $req = $db->prepare($sql);
                $req->bindValue(":name", $movieName);
                $req->bindValue(":date", $movieDate);
                $req->bindValue(":directorFname", $movieDirectorFname);
                $req->bindValue(":directorLname", $movieDirectorLname);
                $req->bindValue(":genre1", $genre1, PDO::PARAM_INT);
                $req->bindValue(":genre2", $genre2, PDO::PARAM_INT);
                $req->bindValue(":genre3", $genre3, PDO::PARAM_INT);
                $req->bindValue(":id", $id);

                //On exécute la requête qui est protégée
                if(!$req->execute()) {
                    http_response_code(500);
                    echo "Désolé, quelque chose n'a pas fonctionné";
                    exit();
                }

                //On redirige l'utilisateur vers la page du film et on passe un message a movie.php
                $message = urlencode("Vous avez modifié la fiche du film : " . $movieName);
                header("Location: movie.php?id=" . $id . "&message=" . $message);

            }
        } else {
            //Ici, soit le formulaire est vide soit incomplet
            $messageErreur = "Le formulaire est incomplet.";
        }
    }

} else {
    header("Location: movie.php?id=" .$id);
}

$title = "$movie->movie_name";
//Integration des du header et de la navbar à la page
include "components/header.php";
include "components/nav.php";

?>

<!-- Style pour les checkboxs des genres | c.f. js/index.js -->
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

<!-- Affichage du message d'erreur s'il n'est pas vide, donc s'il existe -->
<?php if (!empty($messageErreur)): ?>
    <div class="notification is-danger m-5">
        <p><?= htmlspecialchars($messageErreur) ?></p>
    </div>
<?php endif; ?>

<!-- Formulaire mise à jour de la fiche du film -->
<section class="section is-flex is-flex-direction-column is-justify-content-center">
    <form method="post">
        <div class="field">
            <label for="title" class="label">Nom du film</label>
            <div class="control">
                <textarea name="name" class="textarea"><?= $movie->movie_name ?></textarea>
            </div>
        </div>
        <div class="field">
            <label for="content" class="label">Date de la sortie du film</label>
            <div class="control">
                <input name="date" class="input" type="date" value=<?= $movie->movie_date ?>>
            </div>
        </div>
        <div class="field">
            <label for="content" class="label">Réalisteur.trice</label>
            <div class="control mb-3">
                <input type="text" class="input" name="directorFname" value=<?= $movie->movie_directorFname ?>> 
            </div>  
            <div class="control">
                <input type="text" class="input" name="directorLname" value=<?= $movie->movie_directorLname ?>>
            </div>  
        </div>

        <!-- Liste des genres -->
        <div class="field">
            <label class="label">Genres du film (1 à 3 max)</label>
            <div class="tags are-medium" id="genre-container">
                <?php foreach ($genres as $genre): ?>
                    <!-- Affichage des genres déjà sélectionner (avant update) en clair -->
                    <?php if($genre->genre_id === $genre_1 || $genre->genre_id === $genre_2 || $genre->genre_id === $genre_3) :?>
                        <label class="tag is-info is-light">
                        <!-- hidden = cacher "supprimer" la carré de la checkbox -->
                        <input type="checkbox" class="genre-checkbox" name="genres[]" value="<?= $genre->genre_id ?>" hidden>
                        <?= htmlspecialchars($genre->genre) ?>
                    <?php else: ?>
                        <label class="tag is-dark">
                        <!-- hidden = cacher "supprimer" la carré de la checkbox -->
                        <input type="checkbox" class="genre-checkbox" name="genres[]" value="<?= $genre->genre_id ?>" hidden>
                        <?= htmlspecialchars($genre->genre) ?>
                    <?php endif; ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>  

        <div class="control  mt-5">
            <button class="button is-info" type="submit">Modifier mon post</button>
            <a class="button is-danger is-light ml-5" href="movie.php?id=<?= $id ?>"><strong>Annuler</strong> </a>
        </div>
    </form>
</section>

<?php
//Intégration du footer à la page index | indispensable pour le javascript
include "components/footer.php";
?>