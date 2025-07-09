<?php
// Définit la page 404  
http_response_code(404); 

//On démarre la session
session_start();

//Changement du title de la page
$title = "404";

//Intégration du header
include "components/header.php";

?>
<section>
    <section class="hero is-medium is-danger">
        <div class="hero-body">
            <p class="title">404</p>
            <p class="subtitle">La page que vous cherchez est introuvable</p>
        </div>
    </section>

    <section class="section is-flex is-justify-content-center is-align-items-center">   
        <a href="index.php" class="button is-info">Retour à l'accueil</a>
    </section>        
</section>
