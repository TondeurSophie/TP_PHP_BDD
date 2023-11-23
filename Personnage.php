<?php
class Salle {
    private $id; //Ne sert a rien car id en auto-increment
    private $niveau;
    private $epreuve;
    private $recompense;

    public function __construct($niveau, $epreuve, $recompense, $listeArticle,$infoSupplementaire) {
        $this->niveau = $niveau;
        $this->epreuve = $epreuve;
        $this->recompense = $recompense;
    }
    public function getNiveau() {
        return $this->niveau;
    }
    public function getEpreuve() {
        return $this->epreuve;
    }

    public function getRecompense() {
        return $this->recompense;
    }

    public function getId() {
        return $this->id;
    }
}

class Monstre {
    private $id; //Ne sert a rien car id en auto-increment
    private $nom;
    private $pv;
    private $pa;
    private $pd;

    private $exp_donne;


    public function __construct($nom, $pv, $pa,$pd,$exp_donne) {
        $this->nom = $nom;
        $this->pv = $pv;
        $this->pa = $pa;
        $this->pd = $pd;
        $this->exp_donne = $exp_donne;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPv() {
        return $this->pv;
    }
    public function getPa() {
        return $this->pa;
    }
    public function getPd() {
        return $this->pd;
    }
    public function getExpDonne() {
        return $this->exp_donne;
    }
    public function getId() {
        return $this->id;
    }
}


?>