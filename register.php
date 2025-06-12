<?php
    //On démarre la session
    session_start();

    //On se connect à la BDD
    require_once "db.php";

//On vérifie si le formulaire est envoyé
if(!empty($_POST)){
    //Ici, le formulaire est envoyé
    //On vérifie que tout les champs soient remplis
    if(isset($_POST["lname"], $_POST["fname"], $_POST["mail"], $_POST["password"])
    && !empty($_POST["lname"]) && !empty($_POST["fname"]) && !empty($_POST["mail"]) && !empty($_POST["password"])){
        //Ici, on a un formulaire complet
        //On récupère les données en les protégeant
        $lname = strip_tags($_POST["lname"]);
        $fname = strip_tags($_POST["fname"]);

        if(!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
            die("Merci de mettre une adresse email valide.");
        }
        //Ici, je sais que l'email est correct
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
        //On stock dans $_SESSION les infos du user. ATTENTION! JAMAIS DE MOT DE PASSE (email pas recomander)
        $_SESSION ["user"] = [
            "id" => $user->users_id,
            "email" => $user->users_email,
            "fname" => $user->users_fname
        ];

        //On redirige le user vers la page d'accueil
        header("Location: index.php");
        

    } else {
        //Ici, le formulaire est incomplet
        die("Le formulaire est incomplet.");
    }
}




$title = "CMS || S'inscrire";
include "components/header.php";
include "components/nav.php";
?>

<section class="hero is-medium is-success has-text-centered">
    <div class="hero-body">
        <p class="title">
            S'inscrire
        </p>
        <p class="subtitle">
            #register
        </p>
    </div>
</section>

<form style="display: flex; justify-content: center" method="post">
   <div class="card m-6" style="width: 30%">
       <header class="card-header has-background-dark">
           <p class="card-header-title is-size-4 is-centered has-text-light">
               Inscription
           </p>
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
           </div>
       </div>
       <footer class="card-footer control">
           <button class="button is-info card-footer-item is-medium" type="submit"><strong>S'inscrire</strong></button>
       </footer>
   </div>
</form>


<?php 
include "components/footer.php";
?>