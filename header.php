<?php
$index = "login.php";   // page d'accueil
$class_css = " btn-hidden";
if(isset($_SESSION['auth'])){
    $index = "home.php";
    $class_css = "";
    // l'utilisateur est connecté: on récupère ses données en bdd
    $reponse = $bdd->prepare('SELECT * FROM account WHERE id_user = ?');
    $reponse->execute(array($_SESSION['auth']));
    $user = $reponse->fetch();
    // on affiche le nom et le prénom
    $headerText = $user['prenom'] . ' ' . $user['nom'];
}else{
    $headerText = '<a href="inscription.php">Inscription</a>';
}
?>
<header>
    <div id="header1">        
        <a href="<?= $index;?>">
            <img src="images/gbaf.png" alt="logo GBAF">
        </a>
    </div>
    <div id="header2">
        <div id="header21">
            <div id="header211" class="<?= $class_css; ?>">
                <a href="param.php" class="button btn btn-primary ">
                    <i class="fa fa-user"></i>
                </a>
            </div>
            <div id="header212">
                <?= $headerText; ?>
            </div>	
            <div id="header213" class="<?= $class_css; ?>">
                <a href="logout.php" class="button btn btn-danger ">
                    <i class="fa fa-sign-out"></i>
                </a>
            </div>
        </div>        		
    </div>
</header>