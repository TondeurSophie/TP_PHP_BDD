<?php

class Personnages{
    private $id;
    private $nom;
    private $PV;
    private $PA;
    private $PD;
    private $exp;
    private $niveau;

    public function __construct($id,$nom,$PV,$PA,$PD,$exp,$niveau){
        $this->id=$id;
        $this->nom=$nom;
        $this->PV=$PV;
        $this->PA=$PA;
        $this->PD=$PD;
        $this->exp=$exp;
        $this->niveau=$niveau;
    }

    public function getId(){
        return $this->id;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPV(){
        return $this->PV;
    }
    public function getPA(){
        return $this->PA;
    }
    public function getPD(){
        return $this->PD;
    }
    public function getexp(){
        return $this->exp;
    }
    public function getNiveau(){
        return $this->niveau;
    }
}


class Salle{
    private $id;
    private $niveau;
    private $epreuve;
    private $recompense;

    public function __construct($id,$niveau,$epreuve,$recompense){
        $this->id=$id;
        $this->niveau = $niveau;
        $this->epreuve = $epreuve;
        $this->recompense = $recompense;
    }

    public function get_Id(){
        return $this->id;
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