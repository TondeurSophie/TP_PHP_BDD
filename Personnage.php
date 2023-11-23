<?php

//création d'une classe Personnage
class Personnages{
    //création de variables en private car on ne les utilise pas en dehors de la classe
    private $id; //Ne sert a rien car id en auto-increment
    private $nom;
    private $PV;
    private $PA;
    private $PD;
    private $exp;
    private $niveau;

    //Initialisation des propriétés d'un objet à l'aide du constructor
    public function __construct($nom,$PV,$PA,$PD,$exp,$niveau){
        $this->nom=$nom;
        $this->PV=$PV;
        $this->PA=$PA;
        $this->PD=$PD;
        $this->exp=$exp;
        $this->niveau=$niveau;
    }

    //création de fonction _get afin de pouvoir récupérer les valeurs de chaques variables
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


//création d'une classe Salle
class Salle{
    //création de variables en private car on ne les utilise pas en dehors de la classe
    private $id;//Ne sert a rien car id en auto-increment
    private $niveau;
    private $epreuve;
    private $recompense;

    //Initialisation des propriétés d'un objet à l'aide du constructor
    public function __construct($id,$niveau,$epreuve,$recompense){
        $this->id=$id;
        $this->niveau = $niveau;
        $this->epreuve = $epreuve;
        $this->recompense = $recompense;
    }

    //création de fonction _get afin de pouvoir récupérer les valeurs de chaques variables
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


//création d'une classe Monstre
class Monstre {
    //création de variables en private car on ne les utilise pas en dehors de la classe
    private $id; //Ne sert a rien car id en auto-increment
    private $nom;
    private $pv;
    private $pa;
    private $pd;

    private $exp_donne;

    //Initialisation des propriétés d'un objet à l'aide du constructor
    public function __construct($nom, $pv, $pa,$pd,$exp_donne) {
        $this->nom = $nom;
        $this->pv = $pv;
        $this->pa = $pa;
        $this->pd = $pd;
        $this->exp_donne = $exp_donne;
    }

    //création de fonction _get afin de pouvoir récupérer les valeurs de chaques variables
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

//création d'une classe Monstre
class Arme {
    //création de variables en private car on ne les utilise pas en dehors de la classe
    private $id; //Ne sert a rien car id en auto-increment
    private $nom;
    private $niveauRequis;
    private $pv;
    private $pa;
    private $pd;


    //Initialisation des propriétés d'un objet à l'aide du constructor
    public function __construct($nom, $niveauRequis, $pv, $pa,$pd) {
        $this->nom = $nom;
        $this->niveauRequis = $niveauRequis;
        $this->pv = $pv;
        $this->pa = $pa;
        $this->pd = $pd;
    }

    //création de fonction _get afin de pouvoir récupérer les valeurs de chaques variables
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
    public function getNiveauRequis() {
        return $this->niveauRequis;
    }
    public function getId() {
        return $this->id;
    }
}
?>