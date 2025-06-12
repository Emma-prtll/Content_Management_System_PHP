<?php
//On démarre la session (On doit tjr démarrer la session si on en a besoin)
session_start();

//On supprime la partie "user" de la session (du cookie) | on reprend le nom de la session de quand on la open (->login)
unset($_SESSION["user"]);

//On redirige le user vers la home
header("Location: index.php");
?>