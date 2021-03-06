<?php 
session_start();
// connexion database
require("connexionDB.php");

$subtitle ="Contact";
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
        <h1>Contact</h1>
        <p>Remplissez le formulaire suivant pour nous contacter</p>
        <form method="post"  class="form-1"> 
	        <div class="form-group">
                <label><strong>Email</strong></label>
                <input type="text" name="mail" value="" class="form-control">
            </div>
        	<div class="form-group">
                <label><strong>Message</strong></label>
                <input type="text" name="message" value="" required class="form-control">
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
