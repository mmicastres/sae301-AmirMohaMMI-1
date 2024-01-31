<?php
include "Modules/tags.php";
/**
* Définition d'une classe permettant de gérer les itinéraires 
*   en relation avec la base de données	
*/
class TagsManager {
    private $_db;
    public function __construct($db) {
		$this->_db=$db;
	}
    public function getList() {
		$projets = array();
		$req = "SELECT * FROM tags";
		$stmt = $this->_db->prepare($req);
		$stmt->execute();
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		// récup des données
		while ($donnees = $stmt->fetch())
		{
			$projets[] = new Tags($donnees);
		}
		return $projets;
	}

}