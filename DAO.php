<?php

// include("config.php");
// include("classes.php");
// include("index.php");

class DAO{
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterPersonnage(Personnages $personnages) {
        try {
            //Requête SQL permettant d'insérer un personnage dans la BDD avec ses attributs (nom, niveau et etoile)
            $requete = $this->bdd->prepare("INSERT INTO personnage (nom, PV,PA,PD,exp_donne,niveau) VALUES (?,?,?,?,?,?)");
            // création du personnage avec les valeurs de l'objet Utilisateur
            $requete->execute([$personnages->getNom(), $personnages->getPV(),$personnages->getPA(),$personnages->getPD(),$personnages->getexp(),$personnages->getNiveau()]);
            return true; //si tout fonctionne, on revoie true
        } 
        //gestion d'erreur
        catch (PDOException $e) {
            //message d'erreur
            echo "Erreur d'ajout du personnage : " . $e->getMessage();
            //on retourne false
            return false;
        }
    }

    public function listerPersonnage() {
        try {
            // requête qui permet de récupérer tous les personnages
            $requete = $this->bdd->prepare("SELECT * FROM personnage");
            //execution de la requete précédente
            $requete->execute();
            // Retourne un tableau avec les personnages
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des personnages : " . $e->getMessage();
            return [];
        }
    }

    public function modifierPersonnage($Pv,$id){
        try{
            $requete=$this->bdd->prepare("UPDATE personnage SET Pv = ? WHERE id = ?");
            $requete->execute([$Pv,$id]);
            return true;
        }catch (PDOException $e){
            echo "Erreur modif salaire ".$e->getMessage();
        }
    }
}





?>