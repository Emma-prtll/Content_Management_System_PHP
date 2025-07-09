<?php
//On démarre la session
session_start();
    
//On vérifie si le forumulaire est envoyé
if(!empty($_POST)){
    //Ici, le formulaire est envoyé
    //On vérifie si les champs sont remplis
    if(isset($_POST["mail"], $_POST["password"]) && !empty($_POST["mail"]) && !empty($_POST["password"])){

        //On initialise deux booleans afin de savoir si il y a des erreur ou non et donc si on peut poursuivre l'execution du code
        $erreur = false;
        $erreurMail = false;

        //Ici, on a toutes les infos
        //On vérfie que l'email en est un
        if(!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
            //Le mail n'est pas valide donc la variable $erreurMail devient true
            $erreurMail = true;
        } else {
            //Ici, on a une adresse email correct
            //Ici, on va chercher le user sur la BDD, si il existe
            require_once "db.php";
            $sql = "SELECT * FROM `users` WHERE `users_email` = :email";
            $req = $db->prepare($sql);
            $req->bindValue(":email", $_POST["mail"], PDO::PARAM_STR);
            $req->execute();
            $user = $req->fetch();
        }

        //Si le user n'est pas trouvable donc false OU que $erreurMail est true, on informe via le message qu'il y a une erreur
        if(!$user || $erreurMail){
            $messageErreur = "Informations de connexion incorrectes";
            // $erreur devient true
            $erreur = true;
        } else {
            //Ici, j'ai un user qui existe, je vérifie sont mdp
            if(!password_verify($_POST["password"], $user->users_password)){
                //Ici, le password rentrer ne correspond pas au password dans user de la bdd
                $messageErreur = "Informations de connexion incorrectes";
                // $erreur devient true
                $erreur = true;
            }

            //Si $erreur est false, il n'y a pas d'erreur donc on peut finir l'execution du code
            if(!$erreur){
                //Ici, j'ai un user vérifié et qui peut se connecter
                //On stock dans $_SESSION les infos du user
                $_SESSION ["user"] = [
                    "id" => $user->users_id,
                    // "email" => $user->users_email,
                    "fname" => $user->users_fname
                ];

                //Une fois connecté, on redirige le user vers la page d'accueil
                header("Location: index.php");
            }
        }

    } else {
        //Ici, le forumulaire est incomplet
        $messageErreur = "Le formulaire est incomplet.";
    }
}

$title = "Se connecter";
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

<!-- Formulaire de connexion -->
<section class="section">
    <form style="display: flex; justify-content: center" method="post">
        <div class="card m-6" style="width: 30%">
            <header class="card-header has-background-dark">
                <p class="card-header-title is-size-4 is-centered has-text-light">Connection</p>
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
</section>

<?php
//Intégration du footer à la page 
include "components/footer.php";
?>