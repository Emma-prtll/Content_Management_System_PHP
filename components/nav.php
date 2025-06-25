<!-- NOTION / Module 4 - PHP / Navbar - Connecter ou non -->

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <span class="tag has-background-primary-light is-medium m-2"> CMS </span>
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <!-- On ouvre notre php, si le script name de nos infos serveur est égales à la page active, alors on ajoute  -->
            <a class="navbar-item <?php if($_SERVER["SCRIPT_NAME"] === "/index.php") { echo "has-text-success"; } else { echo ""; } ?>" href="index.php">Accueil</a>
            <a class="navbar-item <?php if($_SERVER["SCRIPT_NAME"] === "/blog.php") { echo "has-text-success"; } else { echo ""; } ?>" href="blog.php">Blog</a>  

            <!-- On met un if qui permet de faire la différence entre un user connecté ou non = affiche ou non le bouton -->
            <?php if(isset($_SESSION["user"])) : ?> 
                <a class="navbar-item <?php if($_SERVER["SCRIPT_NAME"] === "/addMovie.php") { echo "has-text-success"; } else { echo ""; } ?>"
                href="addMovie.php">Ajouter un post</a> 
            <?php endif; ?>

        </div>
    </div>
    <div class="navbar-end">
        <div class="navbar-item">
            <div class="buttons">
            <!-- On met un if qui permet de faire la différence entre un user connecté ou non = affiche ou non le bouton -->
            <?php if(!isset($_SESSION["user"])) : ?> 
                <a href="/register.php" class="button is-primary"> <strong>S'inscrire</strong> </a>
                <a href="/login.php" class="button is-info is-dark">Se connecter</a>
            <?php else: ?>
                <!-- Sinon on affiche le bouton logout car le user est connecté -->
                <a href="/logout.php" class="button is-danger is-dark">Se déconnecter</a>
            <?php endif; ?>
            </div>
        </div>
    </div>
</nav>