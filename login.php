<?php 
session_start();
// connexion database
include("connexionDB.php");
include("library.php");

$message .= "";
if (!empty($_POST) && $bdd != null) {
    //vérification des identifiants
    if (login(secure($_POST['username']),secure($_POST['password']),$bdd)) {
        header('Location: home.php');
    }else{
        $message = 'Mauvais identifiants';
    }
}

/**
*	vérifie le mot de passe fourni avec celui en base de donnée
*	@param username
*	@param password
*   @param bdd
*	@return boolean renvoie true si le mot de passe correspond
*/
function login($username, $password,$bdd){
    // on récupère les données de l'utilisateur selon le pseudo fourni
    $reponse = $bdd->prepare('SELECT * FROM account WHERE username = ?');
    $reponse->execute(array($username));
    $user = $reponse->fetch();
    // on vérifie la validité des identifiants fournis
    if ($user) {
        if(password_verify($password,$user['password'])){
            $_SESSION['auth'] = $user['id_user'];
            return true;
        }			
    }
    return false;
}

$subtitle ="Connexion";
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
        <h1>Connexion</h1>
        <?php if(!empty($message)): ?>
            <div class="alert alert-danger">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <form method="post" class="form-1">
            <div class="form-group">
                <label><strong>Pseudo</strong></label>
                <input type="text" name="username" value="" required class="form-control">
            </div>
            <div class="form-group">
                <label><strong>Mot de passe</strong></label>
                <input type="text" name="password" value="" required class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </form>
        <p>
            <a href="inscription.php">S'inscrire</a> ou <a href="forgotPass.php">Mot de passe oublié?</a>
        </p>
    </div>
    <!-- FOOTER   -->
    <?php include("footer.php"); ?>
</body>
</html>
