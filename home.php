<?php 
session_start();
// connexion database
require("connexionDB.php");
require("library.php");

$message .= "";
// on vérifie que l'utilisateur est identifié        
if(isset($_SESSION['auth']) && $bdd != null){
    $user = findUser($_SESSION['auth'],$bdd);
}else{
    header("Location: login.php");
}  
// on récupère tous les acteurs
$partners = getPartnersOrdered($bdd);

$subtitle ="Accueil";
?>
<!doctype html>
<html lang="fr">
  <head>
    <title>GBAF - <?= $subtitle; ?></title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="viewport-fit=cover, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="css/styles_mobile.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  </head>
  <body>
    <!-- HEADER   -->
    <?php include("header.php"); ?>
    <!-- MAIN -->
    <div class="content" style="padding-top: 30px">
        <?php if(!empty($message)): ?>
            <div class="alert alert-danger">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <section id="presentation">
            <div class="presentation2">
                <div class="item-1"><img src="images/banque_postale.png" alt="logo Banque Postale"></div>
                <div class="item-2"><img src="images/bnp_paribas.png" alt="logo BNP Paribas"></div>
                <div class="item-3"><img src="images/BPCE.png" alt="logo BPCE"></div>
                <div class="item-4"><img src="images/cic.png" alt="logo CIC"></div>
                <div class="item-5"><img src="images/credit_agricole.png" alt="logo Crédit Agricole"></div>
                <div class="item-6"><img src="images/societe_generale.png" alt="logo Société Générale"></div>
            </div>
            <h1>GBAF</h1>
            <div id="presentation1">
                <p>Le Groupement Banque Assurance Français (GBAF) est une fédération représentant les 6 
                grands groupes français:</p>
                <ul>
                    <li>BNP Parisbas</li>
                    <li>BPCE</li>
                    <li>Crédit Agricole</li>
                    <li>Crédit Mutuel - CIC</li>
                    <li>Société Générale</li>
                    <li>La Banque Postale</li>
                </ul>
                <p>Même s'il existe une forte concurrence entre ces entités, elles vont toutes travailler
                    de la même façon pour gérer près de 80 millions de comptes sur le territoire national.
                    <br>
                    Le GBAF est le représentant de la profession bancaire et des assureurs sur tous les axes 
                    de la réglemenation financière francaise. Sa mission est de promouvoir l'activité 
                    bancaire à l'échelle nationale. C'est un interlocuteur privilégié des pouvoirs
                    publics.
                </p>
            </div>    
        </section>
        <section id="partners">
            <h2>Acteurs et partenaires</h2>
            <div id="partnersText">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Nunc ornare maximus vehicula. Duis nisi velit, dictum id mauris vitae, lobortis pretium quam. 
                Quisque sed nisi pulvinar, consequat justo id, feugiat leo. Cras eu elementum dui.
            </div>
            <?php foreach ($partners as $partner): ?>	
                <div class="partner">
                    <div class="partner1">
                        <img class="partnerIcon" src="images/<?= $partner['logo']; ?>" alt="logo acteur">
                    </div>
                    <div class="partner2">                
                        <div class="partnerText">
                            <h3><?= secure($partner['acteur']); ?></h3>
                            <p><?=  secure(substr($partner['description'], 0, 150)); ?></p>					
                        </div>
                        <div class="partnerBtn">
                            <a href="partners.php?id=<?= $partner['id_acteur']; ?>" class="button btn btn-primary" >
                            <strong>Détails</strong>
                            </a>               
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
    <!-- FOOTER   -->
    <?php include("footer.php"); ?>
</body>
</html>
