<?php 
session_start();
// connexion database
include("connexionDB.php");
include("library.php");

$message = "";		
if(!empty($_POST)){
    $message = checkParam($_POST);
    if(empty($message)){
        // vérification de l'unicité du pseudo
        if(findUserByUsername(secure($_POST['username']),$bdd)){
            $message = "Pseudo déjà utilisé.";
        }else{
            $sql = 'INSERT INTO account (nom, prenom, username, password, question, reponse) 
                    VALUES (?,?,?,?,?,?)';
            $request = $bdd->prepare($sql);
            $request->execute(array(
                secure($_POST['nom']),
                secure($_POST['prenom']),
                secure($_POST['username']),
                password_hash(secure($_POST['password']),PASSWORD_DEFAULT),
                secure($_POST['question']),
                password_hash(secure($_POST['reponse']),PASSWORD_DEFAULT)
            ));
            header('Location: login.php');
        }				
    }
}
$subtitle ="Inscription";
?>
<!doctype html>
<html lang="en">
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
        <h1>Inscription</h1>
        <p>Remplissez le formulaire pour vous inscrire.</p>
        <?php if(!empty($message)): ?>
            <div class="alert alert-danger">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <form method="post" class="form-1">
            <div class="form-group">
                <label><strong>Nom</strong></label>
                <input type="text" name="nom" value="" required class="form-control">
            </div>    
            <div class="form-group">
                <label><strong>Prénom</strong></label>
                <input type="text" name="prenom" value="" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Pseudo</strong></label>
                <input type="text" name="username" value="" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Mot de passe</strong></label>
                <input type="password" name="password" value="" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Question secrète</strong></label>
                <input type="text" name="question" value="" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Réponse à la question secrète</strong></label>
                <input type="password" name="reponse" value="" required class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Envoyer</button>  
            </div>
        </form> 
    </div>
    <!-- FOOTER   -->
    <?php include("footer.php"); ?>
</body>
</html>
