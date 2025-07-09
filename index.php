<?php
    //On démarre la session
    session_start();

    //On se connecte à notre BDD
    require_once "db.php";

    //Changement du title de la page
    $title = "A contre champs";

    //Intégration du header et de la navigation
    include "components/header.php";
    include "components/nav.php";

?>

<!-- On vérifie si l'utilisateur.trice est connecté, s'il.elle ne l'est pas alors : -->
<?php if(!isset($_SESSION["user"])) : ?>
  <!-- Texte explicatif du site -->
  <section class="section">
    <div class="content ml-5" style="width: 50%">
      <p class="title is-2">Bienvenue sur A Contre Champs</p>
      <p class="subtitle is-4">Ici, c’est ton regard qui compte.</p>
      <p>Tu viens de voir un film qui t’a bouleversé, fait rire, ou carrément déçu ? Tu as un avis différent de la majorité ? Tant mieux.</p>
      <p>À Contre Champs, c’est un espace pensé pour les passionnés de cinéma — qu’ils soient grands amateurs ou simples curieux — qui veulent partager leurs ressentis, noter les films vus, et surtout exprimer librement leur point de vue, même (et surtout) quand il sort des sentiers battus.</p>
      <p class="title is-3">  Ce que tu peux faire ici :</p>
      <ul>
        <li>Explorer les films postés par d’autres cinéphiles</li>
        <li>Lire des critiques personnelles, spontanées, sincères</li>
        <li>T’inspirer pour ta prochaine séance</li>
      </ul>
      <p class="title is-3">Et si tu veux prendre part à la discussion :</p>
      <ul>
        <li>Crée un compte en quelques clics</li>
        <li>Poste tes propres critiques</li>
        <li>Note les films à ta façon</li>
      </ul>
    </div>
  </section>

  <!-- CTA, redirection vers l'inscription, la connexion ou la recherche de film -->
  <section class="section" style="display: flex; justify-content: center">
    <div class="is-centered">
      <a href="/register.php" class="button is-primary"> <strong>S'inscrire</strong> </a>
      <a href="/login.php" class="button is-info is-dark">Se connecter</a>
      <a class="button is-info is-dark <?php if($_SERVER["SCRIPT_NAME"] === "/searchMovie.php") { echo "has-text-success"; } else { echo ""; } ?>" href="searchMovie.php">Chercher un film</a> 
    </div>
  </section>


<!-- Si il ou elle est connecté -->
<?php else: ?>
  <!-- Texte explicatif du site -->
  <section style="display: flex; justify-content: center" class="section">
    <div class="content is-centered ml-5 has-text-centered	" style="width: 50%">
      <p class="title is-2">Salut, <?= htmlspecialchars($_SESSION["user"]["fname"]) ?></p>
      <p class="subtitle is-4">Ici, c’est ton regard qui compte.</p>
      <p>C’est quoi le dernier film que tu as vu ? Crée un post pour nous le dire, on veut connaître ton avis !</p>
      <p>N’oublie pas de regarder ce que les autres ont partagé et de réagir avec un commentaire.</p>
      <p>D’autres ont peut-être aussi commenté tes posts, va voir ce qu’ils en pensent !</p>
    </div>
  </section>

  <!-- CTA, redirection vers le blog ou la recherche de film -->
  <section class="section" style="display: flex; justify-content: center">
    <div class="is-centered">
      <a class="button is-info is-dark <?php if($_SERVER["SCRIPT_NAME"] === "/blog.php") { echo "has-text-success"; } else { echo ""; } ?>" href="blog.php">Découvrir les posts</a>  
      <a class="button is-info is-dark <?php if($_SERVER["SCRIPT_NAME"] === "/searchMovie.php") { echo "has-text-success"; } else { echo ""; } ?>" href="searchMovie.php">Chercher un film</a> 
    </div>
  </section>
<?php endif; ?>

<?php
    //Intégration du footer à la page
    include "components/footer.php"
?>