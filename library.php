<?php
/**
 * vérifie la validité des paramètres du compte
 * @param params variable $_POST
 * @return array renvoie un tableau contenant $message et $errors
 */
function checkParam($params){
    $message = "";
    if(isset($_POST['nom']) && strlen(secure($_POST['nom']))<2){
        $message .= "Nom invalide <br>";
    }
    if(isset($_POST['prenom']) && strlen(secure($_POST['prenom']))<2){
        $message .= "Prénom invalide <br>";
    }
    if(isset($_POST['username']) && strlen(secure($_POST['username']))<4){
        $message .= "Pseudo invalide <br>";
    }
    if(isset($_POST['password']) && strlen(secure($_POST['password']))<4){
        $message .= "Mot de passe invalide <br>";
    }
    if(isset($_POST['question']) && strlen(secure($_POST['question']))<10){
        $message .= "Question invalide <br>";
    }
    if(isset($_POST['reponse']) && strlen(secure($_POST['reponse']))<4){
        $message .= "Réponse invalide <br>";
    }
    return $message;
}

/**
 * nettoie une chaine de caractère
 * @param string data la chaine à nettoyer
 * @return
 */
function secure($data){
    if(is_string($data)){
        $data = htmlspecialchars(stripslashes(trim($data)));
    }
    return$data;
}

/**
 * récupère le compte dont on fourni le pseudo en paramètre
 * @param username 
 * @param bdd
 * @return 
 */
function findUserByUsername($username,$bdd){
    $user = null;
    $reponse = $bdd->prepare('SELECT * FROM account WHERE username = ?');
    $reponse->execute(array($username));
    $user = $reponse->fetch();
    return $user;
}

/**
 * récupère le compte qui a l'id fourni en paramètre
 * @param id 
 * @param bdd
 * @return 
 */
function findUser($id,$bdd){
    $user = null;
    $reponse = $bdd->prepare('SELECT * FROM account WHERE id_user = ?');
    $reponse->execute(array($id));
    $user = $reponse->fetch();
    return $user;
}

/**
 * récupère la liste des acteurs par ordre alphabétique
 * @param bdd
 * @return 
 */
function getPartnersOrdered($bdd){
    $partners = [];
    $reponse = $bdd->prepare('SELECT * FROM acteur ORDER BY acteur');
    $reponse->execute();
    $partners = $reponse->fetchAll();
    return $partners;
}

/**
 * récupère l'acteur qui a l'id fourni en paramètre
 * @param id 
 * @param bdd
 * @return 
 */
function findPartner($id,$bdd){
    $partner = null;
    $reponse = $bdd->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
    $reponse->execute(array($id));
    $partner = $reponse->fetch();
    return $partner;
}