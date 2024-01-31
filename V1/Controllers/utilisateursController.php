<?php
include "Modules/utilisateur.php";
include "Models/utilisateurManager.php";
/**
* Définition d'une classe permettant de gérer les utilisateurs 
*   en relation avec la base de données	
*/
class UtilisateurController {
    private $utilisateurManager; // instance du manager
    private $twig;

	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db, $twig) {
		$this->utilisateurManager = new UtilisateurManager($db);
		$this->twig = $twig;
	}
        
	/**
	* connexion
	* @param aucun
	* @return rien
	*/
	function utilisateurConnexion($data) {
		// verif du mail et mot de passe
		// if ($_POST['email']=="user" && $_POST['idiut']=="pass")
		$utilisateur = $this->utilisateurManager->verif_identification($_POST['email'], $_POST['idiut']);
		if ($utilisateur != false) { // acces autorisé : variable de session acces = oui
			$_SESSION['acces'] = "oui";
			$_SESSION['idutilisateur'] = $utilisateur->idutilisateur();
			$message = "Bonjour ".$utilisateur->prenom()." ".$utilisateur->nom()."!";
			echo $this->twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message)); 
		} else { // acces non autorisé : variable de session acces = non
			$message = "identification incorrecte";
			$_SESSION['acces'] = "non";
			echo $this->twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message)); 
    	} 
	}

	/**
	* deconnexion
	* @param aucun
	* @return rien
	*/
	function utilisateurDeconnexion() {
		$_SESSION['acces'] = "non"; // acces non autorisé
		$message = "vous êtes déconnecté";
		echo $this->twig->render('index.html.twig',array('acces'=> $_SESSION['acces'],'message'=>$message)); 
	 
	}

	/**
	* formulaire de connexion
	* @param aucun
	* @return rien
	*/
	function utilisateurFormulaire() {
		echo $this->twig->render('membre_connexion.html.twig',array('acces'=> $_SESSION['acces'])); 
	}

	function utilisateurFormulaireInscr() {
		echo $this->twig->render('membre_inscription.html.twig',array('acces'=> $_SESSION['acces'])); 
	}

	public function ajoutUti() {
		$uti = new Utilisateur($_POST);
		$ok = $this->utilisateurManager->addUti($uti);
		$message = $ok ? "utilisateur ajouté" : "probleme lors de l'ajout";
		echo $this->twig->render('index.html.twig',array('message'=>$message,'acces'=> $_SESSION['acces'])); 

	}
	
}