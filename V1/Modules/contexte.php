<?php
/** 
* définition de la classe contexte
*/
class Contexte {
        private $idcontexte;
        private $identifiant;	
        private $semestre;	
        private $intitule;		
        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
        if (isset($donnees['idcontexte'])) { $this->_idcontexte = $donnees['idcontexte']; }
			if (isset($donnees['identifiant'])) { $this->_identifiant = $donnees['identifiant']; }
            if (isset($donnees['semestre'])) { $this->_semestre = $donnees['semestre']; }
            if (isset($donnees['intitule'])) { $this->_intitule = $donnees['intitule']; }
						
        }           
        // GETTERS //
        public function idcontexte() { return $this->_idcontexte;}
		public function identifiant() { return $this->_identifiant;}
        public function semestre() { return $this->_semestre;}
        public function intitule() { return $this->_intitule;}
				
		// SETTERS //
        public function setidcontexte(int $idcontexte) { $this->_idcontexte = $idcontexte; }
		public function setidentifiant(int $identifiant) { $this->_identifiant = $identifiant; }
        public function setsemestre(int $semestre) { $this->_semestre = $semestre; }
        public function setintitule(int $intitule) { $this->_intitule = $intitule; }
      		
    }

?>