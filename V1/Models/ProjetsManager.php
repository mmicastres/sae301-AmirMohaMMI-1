<?php
/**
* Définition d'une classe permettant de gérer les projets 
*   en relation avec la base de données	
*/
class ProjetManager {
    
	private $_db; // Instance de PDO - objet de connexion au SGBD
        
	/**
	* Constructeur = initialisation de la connexion vers le SGBD
	*/
	public function __construct($db) {
		$this->_db=$db;
	}
        
	/**
	* ajout d'un projet dans la BD
	* @param projet à ajouter
	* @return int true si l'ajout a bien eu lieu, false sinon
	*/
	public function add(Projet $pro) {
		// calcul d'un nouveau code de projet non déja utilisé = Maximum + 1
		$stmt = $this->_db->prepare("SELECT max(idprojet) AS maximum FROM projet");
		$stmt->execute();
		$pro->setIdprojet($stmt->fetchColumn()+1);
		
		// requete d'ajout dans la BD
		$req = "INSERT INTO projet (idprojet, idcategorie,idcontexte,titre,description,image,demolink,sourceslink) VALUES (?,?,?,?,?,?,?,?)";
		$stmt = $this->_db->prepare($req);
		var_dump($pro);
		$res  = $stmt->execute(array($pro->idProjet(), $pro->idCategorie(), $pro->idContexte(), $pro->titre(), $pro->description(), $pro->image(), $pro->demolink(), $pro->sourceslink()));		
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		return $res;
	}
        
	/**
	* nombre de projets dans la base de données
	* @return int le nb de projets
	*/
	public function count():int {
		$stmt = $this->_db->prepare('SELECT COUNT(*) FROM projet');
		$stmt->execute();
		return $stmt->fetchColumn();
	}
        
	/**
	* suppression d'un projet dans la base de données
	* @param Projet 
	* @return boolean true si suppression, false sinon
	*/
	public function delete(Projet $pro) : bool {
		$req = "DELETE FROM projet WHERE idprojet = ?";
		$stmt = $this->_db->prepare($req);
		return $stmt->execute(array($pro->idProjet()));
	}
		
	/**
	* echerche dans la BD d'un projet à partir de son id
	* @param int $idprojet
	* @return Projet 
	*/
	public function get(int $idprojet) : Projet {	
		$req = 'SELECT idprojet,titre,description,image,demolink,sourceslink,idcategorie,idcontexte FROM projet WHERE idprojet=?';
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($idprojet));
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		$pro = new Projet($stmt->fetch());
		return $pro;
	}		
		
	/**
	* retourne l'ensemble des projets présents dans la BD 
	* @return Projet[]
	*/
	public function getList() {
		$pros = array();
		$req = "SELECT idprojet,titre,description,image,demolink,sourceslink,idcategorie,idcontexte FROM projet";
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
			$pros[] = new Projet($donnees);
		}
		return $pros;
	}

	public function getListcategorie() {
		$pros = array();
		$req = "SELECT idcategorie,nomcategorie FROM categorie";
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
			$pros[] = new Categorie($donnees);
		}
		return $pros;
	}

	
	public function getListcontexte() {
		$pros = array();
		$req = "SELECT idcontexte,identifiant, semestre, intitule FROM contexte";
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
			$pros[] = new Contexte($donnees);
		}
		return $pros;
	}

	public function getDetail($id) {
		$pros = array();
		$req = "SELECT idprojet,titre,description,image,demolink,sourceslink,idcategorie,idcontexte FROM projet WHERE idprojet=? ";
		$stmt = $this->_db->prepare($req);
		$stmt->execute(array($id));
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		// récup des données
		while ($donnees = $stmt->fetch())
		{
			$pros[] = new Projet($donnees);
		}
		return $pros;
	}


	/**
	* retourne l'ensemble des projets présents dans la BD pour un membre
	* @param int idmembre
	* @return Projet[]
	*/
	// public function getListutilisateur(int $idutilisateur) {
	// 	$pros = array();
	// 	$req = "SELECT idprojet,titre,description,image,demolink,sourceslink,idcategorie,idcontexte FROM projet WHERE idutilisateur=?";
	// 	$stmt = $this->_db->prepare($req);
	// 	$stmt->execute(array($idutilisateur));
	// 	// pour debuguer les requêtes SQL
	// 	$errorInfo = $stmt->errorInfo();
	// 	if ($errorInfo[0] != 0) {
	// 		print_r($errorInfo);
	// 	}
	// 	// recup des données
	// 	while ($donnees = $stmt->fetch())
	// 	{
	// 		$pros[] = new Projet($donnees);
	// 	}
	// 	return $pros;
	// }

	public function getProjetsParticipes($idutilisateur)
    {
        $sql = "SELECT p.* FROM projet p
                JOIN contribuer c ON p.idprojet = c.idprojet
                WHERE c.idutilisateur = :idutilisateur";

        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':idutilisateur', $idutilisateur, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

	/**
	* méthode de recherche de projets dans la BD à partir des critères passés en paramètre
	* @param string $titre

	* @return Projet[]
	*/
	public function search(string $titre) {
		$req = "SELECT idprojet,titre,description,image,demolink,sourceslink,idcategorie,idcontexte FROM projet";
		$cond = '';

		if ($titre<>"") 
		{ 	$cond = $cond . " titre like '%". $titre ."%'";
		}

		if ($cond <>"")
		{ 	$req .= " WHERE " . $cond;
		}
		// execution de la requete				
		$stmt = $this->_db->prepare($req);
		$stmt->execute();
		// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
		$projets = array();
		while ($donnees = $stmt->fetch())
		{
			$projets[] = new Projet($donnees);
		}
		return $projets;
	}
	
	/**
	* modification d'un projet dans la BD
	* @param Projet
	* @return boolean 
	*/
	public function update(Projet $pro) : bool {
		$req = "UPDATE projet SET lieudepart = :lieudepart, "
					. "lieuarrivee = :lieuarrivee, "
					. "heuredepart = :heuredepart, "
					. "datedepart  = :datedepart, "
					. "tarif = :tarif, "
					. "nbplaces = :nbplaces, "
					. "bagagesautorises= :bagages, "
					. "details = :details" 
					. " WHERE iditi = :iditi";
		//var_dump($pro);

		$stmt = $this->_db->prepare($req);
		$stmt->execute(array(":lieudepart" => $pro->lieuDepart(),
								":lieuarrivee" => $pro->lieuArrivee(),
								":heuredepart" => $pro->heureDepart(),
								":datedepart" => dateChgmtFormat($pro->dateDepart()),
								":tarif" => $pro->tarif(), 
								":nbplaces" => $pro->nbPlaces(),
								":bagages" => $pro->bagagesAutorises(),
								":details" => $pro->details(),
								":idpro" => $pro->idIti() ));
		return $stmt->rowCount();
		
	}
}

// fontion de changement de format d'une date
// tranformation de la date au format j/m/a au format a/m/j
function dateChgmtFormat($date) {
//echo "date:".$date;
		list($j,$m,$a) = explode("/",$date);
		return "$a/$m/$j";
}
?>