<?php 
session_start();
// connexion database
include("connexionDB.php");
include("library.php");

$message .= "";
// on vérifie que l'utilisateur est identifié        
if(isset($_SESSION['auth']) && $bdd != null){
    $user = findUser($_SESSION['auth'],$bdd);
}else{
    header("Location: login.php");
}  
// on récupère tous les acteurs
$partner = findPartner($_GET['id'],$bdd);
if($partner){ 
    if(isset($_POST['comment'])){   // ajout d'un commentaire demandé
        // vérifier validité du commentaire
        if(strlen(secure($_POST['comment']))>4){
            // vérifier l'unicité du commentaire
            if(!findPost($user['id_user'], $partner['id_acteur'],$bdd)){
                //sauver le commentaire en bdd 
                $sql = 'INSERT INTO post (id_user, id_acteur, post) 
                    VALUES (?,?,?)';
                $request = $bdd->prepare($sql);
                $request->execute(array(
                    $user['id_user'],
                    $partner['id_acteur'],
                    secure($_POST['comment'])
                ));
                header('Location: partners.php?id=' . $partner['id_acteur']);
            }else{
                $message = "Vous avez déjà commenté cet acteur.";
            }                    
        }                
    }elseif(isset($_POST['like'])){ // ajout d'un like
        if(!vote($user['id_user'], $partner['id_acteur'],true,$bdd)){
            $message = "Vous avez déjà voté pour  cet acteur.";
        }
    }elseif(isset($_POST['dislike'])){  // ajout d'un dislike
        if(!vote($user['id_user'], $partner['id_acteur'], false,$bdd)){
            $message = "Vous avez déjà voté pour  cet acteur.";
        }                
    }
    $nb_like = countVote($partner['id_acteur'],true,$bdd);
    $nb_dislike = countVote($partner['id_acteur'],false,$bdd);
    $comments = getPostsByPartnerId($partner['id_acteur'],$bdd);    
}else{
    header('Location: notFound.php');
}

/**
 * récupère un commentaire selon son créateur et celui qu'il concerne
 * @param $id_user
 * @param $id_acteur
 * @return
 */
function findPost($id_user, $id_acteur,$bdd){
    $post = null;
    $reponse = $bdd->prepare('SELECT * FROM post WHERE id_user = ? AND id_acteur = ? ');
    $reponse->execute(array($id_user,$id_acteur));
    $post = $reponse->fetch();
    return $post;
}

/**
*	Récupère tous les commentaires sur le partenaire indiqué
*	@param int $partner_id 
*	@return array
*/
function getPostsByPartnerId($id_acteur,$bdd){  
    $posts = [];
    $sql = "
        SELECT id_post, p.id_user, id_acteur, date_add, post, prenom 
        FROM post p 
            LEFT JOIN account a ON a.id_user = p.id_user 
        WHERE p.id_acteur = ? 
        ORDER BY date_add DESC 
    ";
    $reponse = $bdd->prepare($sql);
    $reponse->execute(array($id_acteur));
    $posts = $reponse->fetchAll();
    return $posts;
}

/**
 * récupère le nombre de like/dislike concernant un partenaire
 * @param id_acteur
 * @param bool true pour récupérer les like, false pour les dislike
 * @return
 */
function countVote($id_acteur, bool $like, $bdd){
    $value = -1;
    if($like){
        $value = 1;
    }
    $reponse = $bdd->prepare("SELECT * FROM vote WHERE vote = ? AND id_acteur = ? ");
    $reponse->execute(array($value,$id_acteur));
    return sizeof($reponse->fetchAll());
}

/**
 * appel la fonction qui sauve la vote en bdd et retourne false si le vote existe deja
 * @param $id_user 
 * @param $id_acteur
 * @param $like 
 * @return false si 1 vote associé à id_user & id_acteur existe deja
 */
function vote($id_user,$id_acteur,bool $like,$bdd){
    $existeDeja = false;
    $value = 1;
    if(!$like){
        $value = -1;
    }
    // vérifier l'unicité du vote
    if(!findVote($id_user, $id_acteur,$bdd)){
        // sauvegarde en bdd
        $sql = 'INSERT INTO vote (id_user, id_acteur, vote) VALUES (?,?,?)';
        $request = $bdd->prepare($sql);
        $request->execute(array($id_user,$id_acteur,$value));
        $existeDeja = true;
    }
    return $existeDeja;
}

/**
 * récupère le vote correspondant aux paramètres
 * @param $id_user
 * @param $id_acteur
 * @return
 */
function findVote($id_user, $id_acteur,$bdd){
    $reponse = $bdd->prepare("SELECT * FROM vote WHERE id_user = ? AND id_acteur = ? ");
    $reponse->execute(array($id_user,$id_acteur));
    return $reponse->fetch();
}

/**
 * formate un texte en ajoutant des <li></li> si un ':' est suivi de ';'
 * @param $text le texte à formatter
 * @return
 */
function formatText($text){
    $html = "";
    $pattern = "#:+(.+;+).+#";
    if (preg_match($pattern, $text)){
        // on décompose le text en phrase
        $parts = explode(".",$text);
        foreach($parts as $part){		
            if(preg_match($pattern, $part)){
                $pieces = explode(':',$part);
                $debut = $pieces[0];
                $reste = substr($part, strlen($debut)+1);
                $ul = explode(';', $reste);
                $html .= $debut . '<ul>';
                foreach ($ul as $li) {
                    $html .= '<li>' . $li . '</li>';
                }
                $html .= '</ul>';
            }else{
                $html .= $part . '.';
            }
        }
    }else{
        $html = $text;
    }
    return $html;
}

$subtitle ="Accueil";
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
        <section id="partnerInfos">
            <div id="partnerLogo">
                <img src="images/<?= $partner['logo']; ?>" alt="logo acteur">
            </div>
            <h2><?= secure($partner['acteur']); ?></h2>
            <p><?= formatText(nl2br(secure($partner['description']))); ?></p>
        </section>		
        <section id="comments">
            <div id="headerComments">
                <div>
                    <?php $s = (sizeof($comments)>1)? 's' : '';?>
                     <h3><?= sizeof($comments); ?> commentaire<?= $s; ?></h3>
                </div>
                <div id="block-btn">
                    <div id="btn-comment">
                        <button class="btn btn-primary" onclick="toggleNewComment()">Nouveau commentaire</i></button>
                    </div>
                    <div id="review-btn">
                        <form method="post">
                            <label class="lbl-like"><strong><?= $nb_like; ?></strong></label>
                            <button class="btn btn-success" type="submit" name="like">
                                <i class="fa fa-thumbs-up"></i>
                            </button>
                        </form>
                        <form method="post">
                            <label class="lbl-dislike"><strong><?= $nb_dislike; ?></strong></label>
                            <button class="btn btn-danger" type="submit" name="dislike">
                                <i class="fa fa-thumbs-down">
                            </i></button>
                        </form>
                    </div>
                </div>				
            </div>
            <div id="listComments">
                <form method="post" id="newComment" class="form-1">
                    <div class="form-group">
                        <label><strong>Laisser un commentaire</strong></label>
                        <textarea name="comment" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
                <?php if(strlen($message)): ?>
                    <div class="alert alert-danger">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>
                <p>Taux de satisfaction: <strong><?= number_format(($nb_like/($nb_like+$nb_dislike))*100); ?>% 
                    </strong> (<?= $nb_like+$nb_dislike; ?> vote<?= $s; ?>)</p>                    
                <?php foreach ($comments as $comment): ?>	
                    <div class="comment">
                        <p><strong><?= secure($comment['prenom']); ?></strong></p>
                        <p>Publié le <?= date('d/m/Y à H:i:s',strtotime($comment['date_add'])); ?></p>
                        <p><?= secure($comment['post']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <script type="text/javascript" src="js/script.js"></script>
    </div>
    <!-- FOOTER   -->
    <?php include("footer.php"); ?>
</body>
</html>
