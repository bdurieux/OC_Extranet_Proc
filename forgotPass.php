<?php 
session_start();
// connexion database
include("connexionDB.php");
include("library.php");

$hide = true;
$question = "Entrez votre pseudo et répondez à la question.";
$message .= "";		
if (!empty($_POST) && $bdd != null) {
    // on récupère les données de l'utilisateur en bdd d'après son username
    $user = findUserByUsername(secure($_POST['username']),$bdd);			
    if($user){
        $question = $user['question'];
        $hide =false;
        if(isset($_POST['reponse'])){
            // vérification des identifiants
            if (password_verify(secure($_POST['reponse']),$user['reponse'])) {
                header('Location: newPass.php');
            }else{
                $message = "Identifiants incorrects.";
            }
        }        
    }else{
        $message = "Pseudo inconnu.";
    }			
}

$subtitle ="Mot de passe oublié";
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
        <h1>Mot de passe oublié</h1>
        <p>Entrez votre pseudo et répondez à la question secrète pour modifier votre mot de passe.</p>
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
        	<?php if(!$hide) : ?>
            <div>
                <p><strong>Question secrète:</strong></p>
                <p><?= $question;?></p>
                <div class="form-group">
                    <label><strong>Réponse secrète</strong></label>
                    <input type="password" name="reponse" value="" required class="form-control">
                </div>	
            </div>
            <?php endif; ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </form>
    </div>
    <!-- FOOTER   -->
    <?php include("footer.php"); ?>
</body>
</html>
