<?php
//On démarre la session
session_start();
    
//Changement du title de la page
$title = "CMS - Blog";

//Intégration du header et de la navigation
include "components/header.php";
include "components/nav.php";

require_once "db.php";

//Fonction pour tronquer le texte à une limite de caractère afin de faire fonctionner le "voir plus" | $limit = nbr de caractère max
function excerpt(string $content, int $limit = 100)
{
    //Si la longueur du texte est plus petite ou égale à la limite, on ne fait rien. 
    if(strlen($content) <= $limit){
        return $content;
    }
    //On cherche le premier espace après la limite, pour ne pas couper un mot en son milieu | dans le $content, il cherche l'espace (' '), depuis la $limit
    $lastSpace = strpos($content, ' ', $limit);

    //On return la phrase coupée au bon endroit et on met les "..."
    return substr($content, 0, $lastSpace) . '...';
}

//On fait notre requête pour obtenir tous les posts par ordre descendant (plus récent en premier)
$sql = "SELECT * FROM movie";
//Données non sensibles, donc requête non préparée ($db->query() et non pas $db->prepare())
$req = $db->query($sql);
//On récupère toutes les données de la BDD
$movies = $req->fetchAll();

//On va chercher le user auteur du post
$user_id = $_SESSION["user"]["id"];
$sql_user = "SELECT * FROM `users` WHERE users_id = $user_id" ;
$req = $db->query($sql_user);
$user = $req->fetch();
?>

<?php if(isset($_GET["message"])) : ?>
<div class="notification is-warning m-5">
    <p><?= $_GET["message"] ?></p>
</div>
<?php endif ; ?>

<section class="is-flex is-flex-wrap-wrap is-justify-content-center m-4">

    <?php foreach ($movies as $movie): ?>
        <div class="card m-4" style="width: 30%">

            <header class="card-header">
                <div class="card-header-title is-flex-direction-column is-align-item-flex-start">
                    <p class="title is-4"><?= strip_tags($movie->movie_name) ?></p>
                </div>
            </header>

            <div class="card-content">
                <div class="content">
                  <p><strong>Directed by : </strong><?= strip_tags($movie->movie_director) ?></p>
                  <p><strong>Release date : </strong><?= strip_tags(excerpt($movie->movie_date)) ?></p>

                  <p>The information are from : <a href="#"><i> <?= $user->users_fname . " " . $user->users_lname ?></i></a></p>
                </div>
            </div>
            <footer class="card-footer"> 
                <a class="button is-primary is-light card-footer-item" href="movie.php?id=<?= $movie->movie_id ?>">Voir les avis</a>
            </footer>

        </div>
    <?php endforeach; ?>

</section>



<!-- 
<section class="is-flex is-flex-wrap-wrap is-justify-content-space-evenly m-4">
  <div class="card" style="width: 40%">
    <header class="card-header">
      <p class="card-header-title">Component</p>
      <button class="card-header-icon" aria-label="more options">
        <span class="icon">
          <i class="fas fa-angle-down" aria-hidden="true"></i>
        </span>
      </button>
    </header>
    <div class="card-content">
      <div class="content">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
        iaculis mauris.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
        iaculis mauris.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
        iaculis mauris.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
        iaculis mauris.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
        iaculis mauris.
        <a href="#">@bulmaio</a>. <a href="#">#css</a> <a href="#">#responsive</a>
        <br />
        <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
      </div>
    </div>
    <footer class="card-footer">
      <a href="#" class="card-footer-item">Save</a>
      <a href="#" class="card-footer-item">Edit</a>
      <a href="#" class="card-footer-item">Delete</a>
    </footer>
  </div>
  -->

</section>

