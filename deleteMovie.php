<?php
session_start();

    include "components/header.php";
    include "components/nav.php";


//On vérifie qu'on reçoit un ID de la part de post.php
if(!isset($_GET["id"]) || empty($_GET["id"])) {
    //ICI je n'ai pas d'ID, je redirige vers 404.php
    http_response_code(404);
    header("Location: 404.php");
    exit();
}

//Ici, j'ai reçu l'id de l'article. Je l'enregistre dans une variable
$id = $_GET["id"];

//On se connecte à la base de donnée
require_once "db.php";

//On récupère l'article qu'on souhaite supprimer dans notre BDD avec son ID
//Ici, je choisi une requête préparée car l'ID provient de l'url, donc publique, donc je sécurise
$sql = "SELECT * FROM movie WHERE movie_id = :id";
$req = $db->prepare($sql);
$req->bindValue(":id", $id, PDO::PARAM_INT);
$req->execute();
$movie = $req->fetch();

//On vérifie si l'article est vide
if(!$movie) {
    http_response_code(404);
    echo "Désolé, aucun article trouvé";
    exit();
}

//On vérifie que l'article appartienne au user
if($_SESSION["user"]["id"] === $movie->movieUser_id) {
    //Ici, le user à le droit de supprimer l'article car il lui appartient
    $sql = "DELETE FROM movie WHERE movie_id = :id";
    $req = $db->prepare($sql);
    $req->bindValue(":id", $id, PDO::PARAM_INT);
    $req->execute();

    //On redirige l'utilisateur vers la page du film et on passe un message a movie.php
    $message = urlencode("Vous avez supprimez la fiche du film : " . $movieName);
    header("Location: blog.php?message=".$message);
    
} else {
    header("Location: blog.php");
}
