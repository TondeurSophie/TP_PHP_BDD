<?php
class DAO{
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterPersonnage(Personnages $personnages) {
        try {
            //Requête SQL permettant d'insérer un personnage dans la BDD avec ses attributs (nom, PV,PA,PD,exp_donne,niveau)
            $requete = $this->bdd->prepare("INSERT INTO personnage (nom, PV,PA,PD,exp,niveau) VALUES (?,?,?,?,?,?)");
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

    //Infliger des dégats


    public function supprimerPersonnage(Personnages $personnage) {
        try {
            // Préparation de la requête d'insertion
            $requete = $this->bdd->prepare("DELETE FROM personnage WHERE Id = ?");
            
            // Exécution de la requête avec les valeurs de l'objet personnage
            $requete->execute([$personnage->getId()]);
            
            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur d'ajout d'personnage: " . $e->getMessage();
            
            // Retourne faux en cas d'échec
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
    public function ajouterArme(Arme $arme) {
        //Ajout du arme dans la base de données
        try {
            $requete = $this->bdd->prepare("INSERT INTO arme (Nom, Niveau_requis, Pv, PA, PD) VALUES (?, ?, ?, ?, ?)");
            $requete->execute([$arme->getNom(), $arme->getNiveauRequis(), $arme->getPV(), $arme->getPa(), $arme->getPd()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de arme: " . $e->getMessage();
            return false;
        }

    }

    public function listerArme() {
        //Liste des armes en selectionnant toute la table
        try {
            $requete = $this->bdd->prepare("SELECT * FROM arme");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des objets : " . $e->getMessage();
            return [];
        }
    }

    public function listerArmeUtilisable(Arme $arme) {
        try {
            //Récupération des armes utilisable en fonction du niveau du personnage
            $requete = $this->bdd->prepare("SELECT * FROM arme WHERE Niveau_requis <= ?");
            $requete->execute([$arme->getNiveauRequis()]);
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des armes: " . $e->getMessage();
            return [];
        }
    }

    public function ajouterMonstre(Monstre $monstre) {
        //Ajout du monstre dans la base de données
        try {
            $requete = $this->bdd->prepare("INSERT INTO monstre (Nom, Pv, PA, PD, exp_done, PV_initial) VALUES (?, ?, ?, ?, ?)");
            $requete->execute([$monstre->getNom(), $monstre->getPV(), $monstre->getPa(),$monstre->getPd(), $monstre->getExpDonne(),$monstre->getPVInitial()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de monstre: " . $e->getMessage();
            return false;
        }

    }

    public function ressuciterMonstre(Monstre $monstre,$id) {
        try {
            // Préparation de la requête de mise à jour
            $requete = $this->bdd->prepare("UPDATE monstre SET Pv = PV_initial WHERE Id = ?");
            
            // Exécution de la requête avec la valeur de l'Id de votre monstre
            $requete->execute([$id]);
            
            // Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur de mise à jour du monstre: " . $e->getMessage();
            
            // Retourne faux en cas d'échec
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
                return new Monstre($resultat['Nom'], $resultat['Pv'], $resultat['PA'], $resultat['PD'], $resultat['exp_donne'], $resultat['PV_initial']);
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

    public function monterNiveauPersonnage($idPersonnage) {
        try {
            //Récupération des informations sur le personnage en fonction de l'id
            $requetePersonnage = $this->bdd->prepare("SELECT * FROM personnage WHERE Id = ?");
            $requetePersonnage->execute([$idPersonnage]);
            $resultatPersonnage = $requetePersonnage->fetch(PDO::FETCH_ASSOC);

            //Mise à jour du nombre d'étoiles collectées et du niveau du personnage
            $nouveauNiveau = $resultatPersonnage['niveau'] + 1;
            // $nouveauNiveau = $resultatNiveau['numero'];

            //Mise à jour dans la base de données
            $requeteMiseAJour = $this->bdd->prepare("UPDATE personnage SET niveau = ? WHERE Id = ?");
            $requeteMiseAJour->execute([$nouveauNiveau, $idPersonnage]);

            echo "Personnage mis à jour avec succès !\n";
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du personnage : " . $e->getMessage();
            return false;
        }
    }


    
    
}
?>