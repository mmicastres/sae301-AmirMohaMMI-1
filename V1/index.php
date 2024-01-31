<?php
// utilisation des sessions
session_start();

include "moteurtemplate.php";
include "connect.php";

include "Controllers/ProjetsController.php";
include "Controllers/utilisateursController.php";
$projetController = new ProjetController($bdd,$twig);
$memController = new UtilisateurController($bdd,$twig);


// texte du message
$message = "";

// ============================== connexion / deconnexion - sessions ==================

// si la variable de session n'existe pas, on la crée
if (!isset($_SESSION['acces'])) {
   $_SESSION['acces']="non";
}
// click sur le bouton connexion
if (isset($_POST["connexion"]))  {  
  $message = $memController->utilisateurConnexion($_POST);  
}

// deconnexion : click sur le bouton deconnexion
if (isset($_GET["action"]) && $_GET['action']=="logout") { 
    $message = $memController->utilisateurDeconnexion(); 
 } 

// formulaire de connexion
if (isset($_GET["action"])  && $_GET["action"]=="login") {
  $memController->utilisateurFormulaire(); 
}

// formulaire d'inscription
if (isset($_GET["action"])  && $_GET["action"]=="inscr") {
  $memController->utilisateurFormulaireInscr(); 
}

if (isset($_POST["inscription"])) {
  $memController->ajoutUti();
}


// ============================== page d'accueil ==================

// cas par défaut = page d'accueil
if (!isset($_GET["action"]) && empty($_POST)) {
  echo $twig->render('index.html.twig',array('acces'=> $_SESSION['acces'])); 
}

// ============================== gestion des Projets ==================

// liste des projets dans un tableau HTML
//  https://.../index/php?action=liste
if (isset($_GET["action"]) && $_GET["action"]=="liste") {
  $projetController->listeProjets();
}
// liste de mes projets dans un tableau HTML
if (isset($_GET["action"]) && $_GET["action"]=="mesprojets") { 
  $projetController->listeProjetsParticipes($_SESSION['idutilisateur']);
}

if (isset($_GET["action"]) && $_GET["action"]=="detail") {
  $projetController->DetailProjets($_GET['id']);
}

// formulaire ajout d'un projet : saisie des caractéristiques à ajouter dans la BD
//  https://.../index/php?action=ajout
// version 0 : le projet est rattaché automatiquement à un utilisateur déjà présent dans la BD
//              l'idutilisateur est en champ caché dans le formulaire
if (isset($_GET["action"]) && $_GET["action"]=="ajout") {
  $projetController->formAjoutProjet();
 }

// ajout du projet dans la base
// --> au clic sur le bouton "valider_ajout" du form précédent
if (isset($_POST["valider_ajout"])) {
  $projetController->ajoutProjet();
}


// suppression d'un projet : choix du projet
//  https://.../index/php?action=suppr
if (isset($_GET["action"]) && $_GET["action"]=="suppr") { 
  $projetController->choixSuppProjet($_SESSION['idutilisateur']);
}

// supression d'un projet dans la base
// --> au clic sur le bouton "valider_supp" du form précédent
if (isset($_POST["valider_supp"])) { 
  $projetController->suppProjet();
}

// modification d'un projet : choix du projet
//  https://.../index/php?action=modif
if (isset($_GET["action"]) && $_GET["action"]=="modif") { 
  $projetController->choixModProjet($_SESSION['idutilisateur']);
}

// modification d'un projet : saisie des nouvelles valeurs
// --> au clic sur le bouton "saisie modif" du form précédent
//  ==> version 0 : pas modif de l'idprojet ni de l'idutilisateur
if (isset($_POST["saisie_modif"])) {   
  $projetController->saisieModProjet();
}

//modification d'un projet : enregistrement dans la bd
// --> au clic sur le bouton "valider_modif" du form précédent
if (isset($_POST["valider_modif"])) {
  $projetController->modProjet();
}


// recherche du projet : saisie des critres de recherche dans un formulaire
//  https://.../index/php?action=recherc
if (isset($_GET["action"]) && $_GET["action"]=="recher") {
  $projetController->formRechercheProjet();
}

// recherche des projets : construction de la requete SQL en fonction des critères 
// de recherche et affichage du résultat dans un tableau HTML 
// --> au clic sur le bouton "valider_recher" du form précédent
if (isset($_POST["valider_recher"])) { 
  $projetController->rechercheProjet();
}

?>
