<?php
/**
* définition de la classe projet
*/
class Projet {
	private  $_idprojet; 
	private int $_idcategorie;	  
	private int $_idcontexte;
	private string $_titre;
	private string $_description;
	private $_image;
	private $_demolink;
	private $_sourceslink;


		
	// contructeur
	public function __construct(array $donnees) {
	// initialisation d'un produit à partir d'un tableau de données
		if (isset($donnees['idprojet']))       { $this->_idprojet =  $donnees['idprojet']; }
		if (isset($donnees['idcategorie']))  { $this->_idcategorie =  $donnees['idcategorie']; }
		if (isset($donnees['idcontexte'])) { $this->_idcontexte = $donnees['idcontexte']; }
		if (isset($donnees['titre']))    { $this->_titre =    $donnees['titre']; }
		if (isset($donnees['description'])) { $this->_description = $donnees['description']; }
		if (isset($donnees['image']))  { $this->_image =  $donnees['image'];}		
		if (isset($donnees['demolink']))       { $this->_demolink =       $donnees['demolink']; }
		if (isset($donnees['sourceslink']))    { $this->_sourceslink =    $donnees['sourceslink']; }
		
	}           
	// GETTERS //
	public function idProjet()       { return $this->_idprojet;}
	public function idCategorie()    { return $this->_idcategorie;}
	public function idContexte()  { return $this->_idcontexte;}
	public function titre() { return $this->_titre;}
	public function description() { return $this->_description;}
	public function image()  { return $this->_image;}
	public function demolink()       { return $this->_demolink;}
	public function sourceslink()    { return $this->_sourceslink;}
	
		
	// SETTERS //
	public function setidProjet(int $idprojet)             { $this->_idprojet = $idprojet; }
	public function setidCategorie(int $idcategorie)       { $this->_idcategorie = $idcategorie; }
	public function setidContexte(int $idcontexte)   { $this->_idcontexte= $idcontexte; }
	public function setTitre(string $titre) { $this->_titre = $titre; }
	public function setDescription(string $description) { $this->_description = $description; }
	public function setImage($image)   { $this->_image = $image; }
	public function setDemolink($demolink)             { $this->_demolink = $demolink; }
	public function setSourceslink($sourceslink)       { $this->_sourceslink = $sourceslink; }
	
}

