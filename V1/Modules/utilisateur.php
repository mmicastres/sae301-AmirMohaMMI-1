<?php
/** 
* définition de la classe utilisateur
*/
class Utilisateur {
        private  $_idutilisateur;
        private string $_nom;
        private string $_prenom;
		private  $_email;
		private  $_idiut;

		
        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
			if (isset($donnees['idutilisateur'])) { $this->_idutilisateur = $donnees['idutilisateur']; }
			if (isset($donnees['nom'])) { $this->_nom = $donnees['nom']; }
			if (isset($donnees['prenom'])) { $this->_prenom = $donnees['prenom']; }
			if (isset($donnees['email'])) { $this->_email = $donnees['email']; }
			if (isset($donnees['idiut'])) { $this->_idiut = $donnees['idiut']; }
        }           
        // GETTERS //
		public function idUtilisateur() { return $this->_idutilisateur;}
		public function nom() { return $this->_nom;}
		public function prenom() { return $this->_prenom;}
		public function email() { return $this->_email;}
		public function idIut() { return $this->_idiut;}
		
		
		// SETTERS //
		public function setIdUtilisateur(int $idutilisateur) { $this->_idutilisateur = $idutilisateur; }
        public function setNom(string $nom) { $this->_nom= $nom; }
		public function setPrenom(string $prenom) { $this->_prenom = $prenom; }
		public function setEmail(string $email) { $this->_email = $email; }
		public function setIdIut(string $idiut) { $this->_idiut = $idiut; }

    }

?>