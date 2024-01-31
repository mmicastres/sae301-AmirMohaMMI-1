<?php

/**
* Définition d'une classe permettant de gérer les utilisateurs 
* en relation avec la base de données
*
*/

class UtilisateurManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/** 
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }
		
		/**
		* verification de l'identité d'un utilisateur (Login/password)
		* @param string $login
		* @param string $password
		* @return membre si authentification ok, false sinon
		*/
		public function verif_identification($login, $password) {
		//echo $login." : ".$password;
			$req = "SELECT idutilisateur, nom, prenom, idiut, email FROM utilisateur WHERE email=:login and idiut=:password ";
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array(":login" => $login, ":password" => $password));
			if ($data=$stmt->fetch()) { 
				$utilisateur = new Utilisateur($data);
				return $utilisateur;
				}
			else return false;
		}

		public function addUti(Utilisateur $uti) {
			// calcul d'un nouveau code de projet non déja utilisé = Maximum + 1
			$stmt = $this->_db->prepare("SELECT max(idutilisateur) AS maximum FROM utilisateur");
			$stmt->execute();
			$uti->setIdutilisateur($stmt->fetchColumn()+1);
			
			// requete d'ajout dans la BD
			$req = "INSERT INTO utilisateur (idutilisateur,nom,prenom,idiut,email) VALUES (?,?,?,?,?)";

			$stmt = $this->_db->prepare($req);
			var_dump($uti);
			$res  = $stmt->execute(array($uti->idUtilisateur(), $uti->nom(), $uti->prenom(), $uti->idiut(), $uti->email()));
					
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			return $res;
		}
    }
?>