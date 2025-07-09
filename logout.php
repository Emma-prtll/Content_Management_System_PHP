<?php
//On démarre la session
session_start();

//On supprime la partie "user" de la session (du cookie) | on reprend le nom de la session de quand on la open (->login)
unset($_SESSION["user"]);

//On redirige le user vers la home
header("Location: index.php");
?>