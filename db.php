<?php

// Constante d'environnement
const DBHOST = "localhost";
const DBUSER = "root";
const DBPASS = "";
const DBNAME = "cms_bdd";

// On crée notre DSN de connection (DSN = Data Source Name)
$dsn = "mysql:dbname=".DBNAME.";host=".DBHOST;

// Quand le PDO n'arrive pas a se connecter, il return une erreur
try {
    //On instancie PDO
    $db = new PDO($dsn, DBUSER, DBPASS);
    $db->exec("SET NAMES utf8");
    //On définit le type de données retournées par la BDD
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    //Afficher un message de réussite en cas de connexion avec la BDD
    echo "<p style='color: green;'>✅ Connexion à la base de données réussie.</p>";

} catch (PDOException $exception) {
    //Afficher un message d'erreur en cas de connexion ratée avec la BDD
    echo "<p style='color: red;'>❌ Erreur de connexion à la base de données : " . $exception->getMessage() . "</p>";
    die();
}

?>
