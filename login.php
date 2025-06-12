<?php
    //On démarre la session
    session_start();
    
//On vérifie si le forumulaire est envoyé
if(!empty($_POST)){
    //Ici, le formulaire est envoyé
    //On vérifie si les champs sont remplis
    if(isset($_POST["mail"], $_POST["password"]) && !empty($_POST["mail"]) && !empty($_POST["password"])){
        //Ici, on a toutes les infos
        //On vérfie que l'email en est un
        if(!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
            die("Informations de connexion incorrectes");
        }
        //Ici, on a une adresse email correct
        //Ici, on va chercher le user sur la BDD, si il existe
        require_once "db.php";
        $sql = "SELECT * FROM `users` WHERE `users_email` = :email";
        $req = $db->prepare($sql);
        $req->bindValue(":email", $_POST["mail"], PDO::PARAM_STR);
        $req->execute();
        $user = $req->fetch();

        //user introuvable dans la bdd donc retourne boolean false
        if(!$user){
            die("Informations de connexion incorrectes");
        }

        //Ici, j'ai un user qui existe, je vérifie sont mdp
        //Si le password rentrer ne correspond pas au password dans user de la bdd
        if(!password_verify($_POST["password"], $user->users_password)){
            die("Informations de connexion incorrectes");
        }

        //Ici, j'ai un user vérifié et qui peut se connecter
        //On stock dans $_SESSION les infos du user. ATTENTION! JAMAIS DE MOT DE PASSE (email pas recomander)
        $_SESSION ["user"] = [
            "id" => $user->users_id,
            "email" => $user->email,
            "fname" => $user->users_fname
        ];

        //On redirige le user vers la page d'accueil
        header("Location: index.php");

    } else {
        //Ici, le forumulaire est incomplet
        die("Le formulaire est incompler");
    }
}


$title = "CMS || Se connecter";
include "components/header.php";
include "components/nav.php";

?>

<section class="hero is-medium is-success has-text-centered">
    <div class="hero-body">
        <p class="title">
            Se connecter
        </p>
        <p class="subtitle">
            #login
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
           <button class="button is-info card-footer-item is-medium" type="submit"><strong>Se connecter</strong></button>
       </footer>
   </div>
</form>


<?php 
include "components/footer.php";
?>