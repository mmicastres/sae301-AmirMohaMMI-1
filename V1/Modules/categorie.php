<?php
/** 
* définition de la classe categorie
*/
class Categorie {
        private $idcategorie;
        private $nomcategorie;		
        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
        if (isset($donnees['idcategorie'])) { $this->_idcategorie = $donnees['idcategorie']; }
			if (isset($donnees['nomcategorie'])) { $this->_nomcategorie = $donnees['nomcategorie']; }
						
        }           
        // GETTERS //
        public function idcategorie() { return $this->_idcategorie;}
		public function nomcategorie() { return $this->_nomcategorie;}
				
		// SETTERS //
        public function setidcategorie(int $idcategorie) { $this->_idcategorie = $idcategorie; }
		public function setnomcategorie(int $nomcategorie) { $this->_nomcategorie = $nomcategorie; }
      		
    }

?>