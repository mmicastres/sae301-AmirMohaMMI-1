<?php
include "Modules/projets.php";
include "Models/ProjetsManager.php";
include "Modules/categorie.php";
include "Modules/contexte.php";
/**
* Définition d'une classe permettant de gérer les projets 
*   en relation avec la base de données	
*/
class ProjetController {
    
	private $projetManager; // instance du manager
	private $twig;
        
	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db, $twig) {
		$this->projetManager = new ProjetManager($db);
		$this->twig = $twig;
	}
        
	/**
	* liste de tous les projets
	* @param aucun
	* @return rien
	*/
	public function listeProjets() {
		$projets = $this->projetManager->getList();
		echo $this->twig->render('projet_liste.html.twig',array('pros'=>$projets,'acces'=> $_SESSION['acces'])); 
	}

	public function DetailProjets($id) {
		$projets = $this->projetManager->getDetail($id);
		echo $this->twig->render('projet_liste.html.twig',array('pros'=>$projets,'acces'=> $_SESSION['acces'])); 
	}

	/**
	* liste de mes projets
	* @param aucun
	* @return rien
	*/
	// public function listeMesProjets($idutilisateur) {
	// 	$projets = $this->projetManager->getListutilisateur($idutilisateur);
	// 	echo $this->twig->render('projet_liste.html.twig',array('pros'=>$projets,'acces'=> $_SESSION['acces'])); 
	//   }

	  public function listeProjetsParticipes()
    {
        // Supposons que vous ayez une instance de ProjetsManager appelée $projetManager
        $idutilisateur = 1; // Remplacez par l'id de l'utilisateur actuel

        $projetsParticipes = $this->projetManager->getProjetsParticipes($idutilisateur);

        // Transmettez les données à votre vue (Twig)
        return $this->twig->render('projet_listeperso.html.twig', ['projetsParticipes' => $projetsParticipes]);
    }
	/**
	* formulaire ajout
	* @param aucun
	* @return rien
	*/
	public function formAjoutProjet() {
		$categories= $this->projetManager->getListcategorie();
		$contextes= $this->projetManager->getListcontexte();
		echo $this->twig->render('projet_ajout.html.twig',array('acces'=> $_SESSION['acces'],'idutilisateur'=>$_SESSION['idutilisateur'],'pros'=>$categories,'pross'=>$contextes)); 
	}

	/**
	* ajout dans la BD d'un projet à partir du form
	* @param aucun
	* @return rien
	*/
	public function ajoutProjet() {
		$pro = new Projet($_POST);
		$ok = $this->projetManager->add($pro);
		$message = $ok ? "projet ajouté" : "probleme lors de l'ajout";
		echo $this->twig->render('index.html.twig',array('message'=>$message,'acces'=> $_SESSION['acces'])); 

	}
	/**
	* form de choix du projet à supprimer
	* @param aucun
	* @return rien
	*/
	public function choixSuppProjet($idutilisateur) {
		$projets = $this->projetManager->getListutilisateur($idutilisateur);
		echo $this->twig->render('projet_choix_suppression.html.twig',array('pros'=>$projets,'acces'=> $_SESSION['acces'])); 
	}
	/**
	* suppression dans la BD d'un projet à partir de l'id choisi dans le form précédent
	* @param aucun
	* @return rien
	*/
	public function suppProjet() {
		$pro = new Projet($_POST);
		$ok = $this->projetManager->delete($pro);
		$message = $ok ?  "projet supprimé" : "probleme lors de la supression";
		echo $this->twig->render('index.html.twig',array('message'=>$message,'acces'=> $_SESSION['acces'])); 
	}
	/**
	* form de choix du projet à modifier
	* @param aucun
	* @return rien
	*/
	public function choixModProjet($idutilisateur) {
		$projets = $this->projetManager->getListutilisateur($idutilisateur);
		echo $this->twig->render('projet_choix_modification.html.twig',array('pros'=>$projets,'acces'=> $_SESSION['acces'])); 
	}
	/**
	* form de saisi des nouvelles valeurs du projet à modifier
	* @param aucun
	* @return rien
	*/
	public function saisieModProjet() {
		$pro =  $this->projetManager->get($_POST["idprojet"]);
		echo $this->twig->render('projet_modification.html.twig',array('pro'=>$pro,'acces'=> $_SESSION['acces'])); 
	}

	/**
	* modification dans la BD d'un projet à partir des données du form précédent
	* @param aucun
	* @return rien
	*/
	public function modProjet() {
		$pro =  new Projet($_POST);
		$ok = $this->projetManager->update($pro);
		$message = $ok ? "projet modifié" : $message = "probleme lors de la modification";
		echo $this->twig->render('index.html.twig',array('message'=>$message,'acces'=> $_SESSION['acces'])); 
	}

	/**
	* form de saisie des criteres
	* @param aucun
	* @return rien
	*/
	public function formRechercheProjet() {
		echo $this->twig->render('projet_recherche.html.twig',array('acces'=> $_SESSION['acces'])); 
	}

	/**
	* recherche dans la BD de projets à partir des données du form précédent
	* @param aucun
	* @return rien
	*/
	public function rechercheProjet() {
		$projets = $this->projetManager->search($_POST["titre"]);
		echo $this->twig->render('projet_liste.html.twig',array('pros'=>$projets,'acces'=> $_SESSION['acces'])); 
	}
}