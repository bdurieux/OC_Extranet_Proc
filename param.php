<?php 
session_start();
// connexion database
require("connexionDB.php");
require("library.php");

$message .= "";	
if(isset($_SESSION['auth']) && $bdd != null){
    // l'utilisateur est connecté: on récupère ses données en bdd
    $reponse = $bdd->prepare('SELECT * FROM account WHERE id_user = ?');
    $reponse->execute(array($_SESSION['auth']));
    $user = $reponse->fetch();
}else{
    header('Location: login.php');
}
	
if(!empty($_POST) && $bdd != null){
    $message = checkParam($_POST);
    if(empty($message)){
        $pseudoUser = findUserByUsername(secure($_POST['username']),$bdd);
        // on vérifie que le pseudo n'est pas deja utilisé par un autre user
        if($pseudoUser != false && ($pseudoUser['id_user'] != $user['id_user'])){
            $message .= "Pseudo déjà utilisé.";
        }else{
            $sql = 'UPDATE account SET nom = ?, prenom = ?, username = ?, password = ?, question = ?, reponse = ? 
            WHERE id_user = ?';
            $request = $bdd->prepare($sql);
            $request->execute(array(
                secure($_POST['nom']),
                secure($_POST['prenom']),
                secure($_POST['username']),
                password_hash(secure($_POST['password']),PASSWORD_DEFAULT),
                secure($_POST['question']),
                password_hash(secure($_POST['reponse']),PASSWORD_DEFAULT),
                $user['id_user']
            ));
            header('Location: home.php');
        }				
    }
}
$subtitle ="Paramètre du compte";
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
        <h1>Paramètres du compte</h1>
        <?php if(!empty($message)): ?>
            <div class="alert alert-danger">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <form method="post" class="form-1">
            <div class="form-group">
                <label><strong>Nom</strong></label>
                <input type="text" name="nom" value="<?= secure($user['nom']);?>" required class="form-control">
            </div>    
            <div class="form-group">
                <label><strong>Prénom</strong></label>
                <input type="text" name="prenom" value="<?= secure($user['prenom']);?>" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Pseudo</strong></label>
                <input type="text" name="username" value="<?= secure($user['username']);?>" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Mot de passe</strong></label>
                <input type="password" name="password" value="<?= secure($user['password']);?>" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Question secrète</strong></label>
                <input type="text" name="question" value="<?= secure($user['question']);?>" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Réponse à la question secrète</strong></label>
                <input type="password" name="reponse" value="<?= secure($user['reponse']);?>" required class="form-control">
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
