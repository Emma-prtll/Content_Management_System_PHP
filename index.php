<?php
    //On démarre la session
    session_start();
    
    //On se connecte à notre BDD
    require_once "db.php";

    //Changement du title de la page
    $title = "CMS - Home";

    //Intégration du header et de la navigation
    include "components/header.php";
    include "components/nav.php";
?>

<section class="hero is-primary">
  <div class="hero-body">
    <p class="title">Info hero</p>
    <p class="subtitle">Info subtitle</p>
  </div>
</section>

<?php
    //Intégration du footer
    include "components/footer.php"
?>