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


class Salles{
    private $id;
    private $epreuve;
    private $recompense;

    public function __construct($id,$epreuve,$recompense){
        $this->id=$id;
        $this->epreuve=$epreuve;
        $this->recompense=$recompense;
    }

    public function get_Id(){
        return $this->id;
    }

    public function get_epreuve(){
        return $this->epreuve;
    }
    public function get_recompense(){
        return $this->recompense;
    }
}


class Monstre{
    private $id;
    private $nom;
    private $PV;
    private $PA;
    private $PD;
    

    public function __construct($id,$nom,$PV,$PA,$PD){
        $this->id=$id;
        $this->nom=$nom;
        $this->PV=$PV;
        $this->PA=$PA;
        $this->PD=$PD;
 
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
    
}
?>