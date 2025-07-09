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
            <a class="navbar-item <?php if($_SERVER["SCRIPT_NAME"] === "/searchMovie.php") { echo "has-text-success"; } else { echo ""; } ?>" href="searchMovie.php">Chercher un film</a>  
        </div>
    </div>
    <div class="navbar-end">
        <div class="navbar-item">
            <div class="buttons">
            <!-- On met un if qui permet de faire la différence entre un user connecté ou non = affiche ou non le bouton -->
            <!-- SI LE USER EST CONNECTE -->
            <?php if(!isset($_SESSION["user"])) : ?> 
                <a href="/register.php" class="button is-primary"> <strong>S'inscrire</strong> </a>
                <a href="/login.php" class="button is-info is-dark">Se connecter</a>
            <?php else: ?>
            <!-- SI LE USER N'EST PAS CONNECTE -->
                <!-- On le bouton logout car le user est connecté -->
                <a href="/logout.php" class="button is-danger is-dark">Se déconnecter</a>
            <?php endif; ?>
            </div>
        </div>
    </div>
</nav>