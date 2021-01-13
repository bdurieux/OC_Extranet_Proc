<?php 
session_start();
// connexion database
include("connexionDB.php");
include("library.php");

$message .= "";	
$usernamePlaceholder = "";
if(!empty($_GET['username'])){
    $usernamePlaceholder = $_GET['username'];
}
if(!empty($_POST) && $bdd != null){		
    // on récupère les données de l'utilisateur en bdd d'après son username	
    $user = findUserByUsername(secure($_POST['username']),$bdd);
    if($user){				
        if(strlen(secure($_POST['password1']))>0 && secure($_POST['password1']) === secure($_POST['password2'])){
            //faire l'update du password
            $sql = 'UPDATE account SET password = ? WHERE id_user = ?';
            $request = $bdd->prepare($sql);
            $request->execute(array(password_hash(secure($_POST['password1']),PASSWORD_DEFAULT),$user['id_user']));
            //header('Location: login.php');
            header('Location: login.php?username='.$_POST['username']);
        }else{
            $message = "Les 2 mots de passe ne correspondent pas.";
            $usernamePlaceholder = $_POST['username'];
        }
    }else{
        $message = "Pseudo inconnu.";
    }
}
$subtitle ="Nouveau mot de passe";
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
        <h1>Nouveau mot de passe</h1>
        <?php if(!empty($message)): ?>
            <div class="alert alert-danger">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <p>Entrez votre pseudo et votre nouveau mot de passe.</p>
        <form method="post" class="form-1">
            <div class="form-group">
                <label><strong>Pseudo</strong></label>
                <input type="text" name="username" value="<?= $usernamePlaceholder; ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Nouveau mot de passe</strong></label>
                <input type="password" name="password1" value="" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Entrez le nouveau mot de passe</strong></label>
                <input type="password" name="password2" value="" required class="form-control">
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
