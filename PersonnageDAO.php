<?php
class PersonnageDAO {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterMonstre(Monstre $monstre) {
        //Ajout du monstre dans la base de données
        try {
            $requete = $this->bdd->prepare("INSERT INTO monstre (Nom, Pv, PA, PD, exp_done) VALUES (?, ?, ?, ?, ?)");
            $requete->execute([$monstre->getNom(), $monstre->getPV(), $monstre->getPa(), , $monstre->getPd(), , $monstre->getExpDonne()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de monstre: " . $e->getMessage();
            return false;
        }

    }
    public function trouverMonstreParId($id) {
        try {
            //Recherche un monstre en particulier en fonction de l'id
            $requete = $this->bdd->prepare("SELECT * FROM monstre WHERE id = ?");
            $requete->execute([$id]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                return new Monstre($resultat['Nom'], $resultat['Pv'], $resultat['PA'], $resultat['PD'], $resultat['exp_donne']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche du personnage par ID: " . $e->getMessage();
            return null;
        }
    }
    public function ajouterSalle(Salle $salle) {
        //Ajout des niveau (utilisé qu'au début afin de remplir un minimum la base de données)
        try {
            $requete = $this->bdd->prepare("INSERT INTO salle (niveau, epreuve, recompense) VALUES (?, ?)");
            $requete->execute([$salle->getNiveau(), $salle->getEpreuve(), $salle->getRecompense()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de la salle : " . $e->getMessage();
            return false;
        }

    }

    public function listerMonstres() {
        //Liste des monstre en selectionnant toute la table
        try {
            $requete = $this->bdd->prepare("SELECT * FROM monstre");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des monstres: " . $e->getMessage();
            return [];
        }
    }
    public function listerSalleActuelle(Salle $salle) {
        try {
            //Récupération des salles disponibles en fonction du niveau du personnage
            $requete = $this->bdd->prepare("SELECT * FROM salle WHERE niveau = ?");
            $requete->execute([$salle->getNiveau()]);
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des salles: " . $e->getMessage();
            return [];
        }
    }
    public function listerSalle(Salle $salle) {
        try {
            //Récupération de toutes les salles
            $requete = $this->bdd->prepare("SELECT * FROM salle");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des salles: " . $e->getMessage();
            return [];
        }
    }
    public function mettreAJourPersonnage($idPersonnage, $idNiveau) {
        try {
            //Récupération des informations sur le personnage en fonction de l'id
            $requetePersonnage = $this->bdd->prepare("SELECT * FROM personnages WHERE id = ?");
            $requetePersonnage->execute([$idPersonnage]);
            $resultatPersonnage = $requetePersonnage->fetch(PDO::FETCH_ASSOC);

            //Récupération des informations sur le niveau en fonction de l'id
            $requeteNiveau = $this->bdd->prepare("SELECT * FROM niveaux WHERE id = ?");
            $requeteNiveau->execute([$idNiveau]);
            $resultatNiveau = $requeteNiveau->fetch(PDO::FETCH_ASSOC);

            //Mise à jour du nombre d'étoiles collectées et du niveau du personnage
            $nouveauNombreEtoiles = $resultatPersonnage['nombre_etoile_collecte'] + $resultatNiveau['nombre_dispo_etoile'];
            $nouveauNiveau = $resultatNiveau['numero'];

            //Mise à jour dans la base de données
            $requeteMiseAJour = $this->bdd->prepare("UPDATE personnages SET niv_actuel = ?, nombre_etoile_collecte = ? WHERE id = ?");
            $requeteMiseAJour->execute([$nouveauNiveau, $nouveauNombreEtoiles, $idPersonnage]);

            echo "Personnage mis à jour avec succès !\n";
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du personnage : " . $e->getMessage();
            return false;
        }
    }


    
    
}
?>