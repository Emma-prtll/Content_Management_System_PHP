<?php
//On démarre la session
session_start();

//On se connect à la BDD
require_once "db.php";

//On vérifie si le formulaire est envoyé
if(!empty($_POST)){
    //Ici, le formulaire est envoyé
    //On vérifie que tout les champs soient remplis
    if(isset($_POST["lname"], $_POST["fname"], $_POST["mail"], $_POST["password"], $_POST["passwordConf"])
    && !empty($_POST["lname"]) && !empty($_POST["fname"]) && !empty($_POST["mail"]) && !empty($_POST["password"]) && !empty($_POST["passwordConf"])){
        //Ici, le formulaire est rempli

        //On récupère les données en les protégeant et on supprime les potentielles espaces au début et à la fin avec trim()
        $lname = strip_tags(trim($_POST["lname"]));
        $fname = strip_tags(trim($_POST["fname"]));

        //On initialise un boolean afin de savoir si il y a des erreur ou non et donc si on peut poursuivre l'execution du code     
        $erreur = false;

        //On vérifie que le prénom et le nom ne contienne pas de chiffre, ou autre caractère non-utilisable
        $regex = "/^[\p{L} '-]+$/u";
        if (!preg_match($regex, $lname) || !preg_match($regex, $fname)) {
            $messageErreur = "Le nom et le prénom doivent contenir uniquement des lettres.";
            //Ici, il y a une erreur donc $erreur devient true
            $erreur = true;
        }

        //On vérifie que le mail est bien un mail
        if(!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
            $messageErreur = "Merci de remplir par un mail.";
            //Ici, il y a une erreur donc $erreur devient true
            $erreur = true;
        }

        //On vérifie que le mot de passe correspond à la confirmation de mot de passe
        if($_POST["password"] != $_POST["passwordConf"]) {
            $messageErreur = "Les mots de passe ne correspondent pas.";
            //Ici, il y a une erreur donc $erreur devient true
            $erreur = true;
        }

        //Si $erreur est false, il n'y a pas d'erreur donc on peut finir l'execution du code
        if(!$erreur){
            // On force la première lettre en majuscule et les autres en minuscules (en UTF-8)
            $lname = mb_convert_case($lname, MB_CASE_TITLE, "UTF-8");
            $fname = mb_convert_case($fname, MB_CASE_TITLE, "UTF-8");

            //Ici, on hache et sécurise le mdp suivant un algo
            $password = password_hash($_POST["password"], PASSWORD_ARGON2I);

            //On peut enregister notre user
            //Requête préparée car les données viennent du user
            $sql = "INSERT INTO `users` (`users_lname`, `users_fname`, `users_email`, `users_password`) VALUES (:lname, :fname, :email, :password)";
            $req = $db->prepare($sql);
            $req->bindValue(":lname", $lname, PDO::PARAM_STR);
            $req->bindValue(":fname", $fname, PDO::PARAM_STR);
            $req->bindValue(":email", $_POST["mail"], PDO::PARAM_STR);
            $req->bindValue(":password", $password, PDO::PARAM_STR);
            $req->execute();

            $id = $db->lastInsertId();
            $sql = "SELECT * FROM `users`WHERE users_id = :id";
            $req = $db->prepare($sql);
            $req->bindValue(":id", $id, PDO::PARAM_INT);
            $req->execute();
            $user = $req->fetch(); 

            //Ici, j'ai un user vérifié et qui peut se connecter
            //On stock dans $_SESSION les infos du user
            $_SESSION ["user"] = [
                "id" => $user->users_id,
                // "email" => $user->users_email,
                "fname" => $user->users_fname
            ];
            
            //Une fois inscrit, on redirige le user vers la page d'accueil
            header("Location: index.php");
        
        }
    } else {
        //Ici, le formulaire est incomplet
        $messageErreur = "Merci de remplir tout les champs du formulaire.";
    }
}

$title = "Inscription";
//Integration des du header et de la navbar à la page
include "components/header.php";
include "components/nav.php";
?>

<!-- Affichage du message d'erreur s'il n'est pas vide, donc s'il existe -->
<?php if (!empty($messageErreur)): ?>
    <div class="notification is-danger m-5">
        <p><?= htmlspecialchars($messageErreur) ?></p>
    </div>
<?php endif; ?>

<!-- Formulaire d'inscription -->
<form style="display: flex; justify-content: center" method="post">
   <div class="card m-6" style="width: 30%">
       <header class="card-header has-background-dark">
           <p class="card-header-title is-size-4 is-centered has-text-light">Inscription</p>
       </header>

       <div class="card-content">
           <div class="content">
               <div class="field">
                   <label class="label" for="lname">Nom</label>
                   <div class="control">
                       <input class="input" type="text" name="lname" placeholder="Votre nom">
                   </div>
               </div>
               <div class="field">
                   <label class="label" for="fname">Prénom</label>
                   <div class="control">
                       <input class="input" type="text" name="fname" placeholder="Votre prénom">
                   </div>
               </div>               
               <div class="field">
                   <label class="label" for="mail">Adresse email</label>
                   <div class="control">
                       <input class="input" type="email" name="mail" placeholder="Votre adresse email">
                   </div>
               </div>
               <div class="field">
                   <label class="label" for="password">Votre mot de passe</label>
                   <div class="control">
                       <input class="input" type="password" name="password" placeholder="Votre mot de passe">
                   </div>
               </div>
               <div class="field">
                   <label class="label" for="passwordConf">Votre mot de passe</label>
                   <div class="control">
                       <input class="input" type="password" name="passwordConf" placeholder="Confirmez votre mot de passe">
                   </div>
               </div>
           </div>
       </div>

       <footer class="card-footer control">
           <button class="button is-info card-footer-item is-medium" type="submit"><strong>S'inscrire</strong></button>
       </footer>
   </div>
</form>

<?php 
//Intégration du footer à la page 
include "components/footer.php";
?>