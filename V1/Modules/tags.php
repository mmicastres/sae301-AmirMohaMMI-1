<?php
/** 
* définition de la classe categorie
*/
class Tags {
        private $nomtag;		
        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
			if (isset($donnees['nomtag'])) { $this->_nomtag = $donnees['nomtag']; }
						
        }           
        // GETTERS //
		public function nomtag() { return $this->_nomtag;}
				
		// SETTERS //
		public function setnomtag(int $nomtag) { $this->_nomtag = $nomtag; }
      		
    }

?>