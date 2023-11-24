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
            echo "Erreur d'ajout du personnage: " . $e->getMessage();
            
            // Retourne faux en cas d'échec
            return false;
        }
    }

    public function listerPersonnage() {
        try {
            //Requête qui permet de récupérer tous les personnages
            $requete = $this->bdd->prepare("SELECT * FROM personnage");
            //Execution de la requete précédente
            $requete->execute();
            //Retourne un tableau avec les personnages
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
            //Modifie les PV en PV_Initial pour ressuciter les monstres
            $requete = $this->bdd->prepare("UPDATE monstre SET Pv = PV_initial WHERE Id = ?");
            
            $requete->execute([$id]);
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, affiche un message d'erreur
            echo "Erreur de mise à jour du monstre: " . $e->getMessage();
            
            // Retourne faux en cas d'échec
            return false;
        }
    }

    public function attaquerMonstre($idPersonnage, $idMonstre) {
        try {
            // Récupérer les points d'attaque du personnage depuis la base de données
            $requetePersonnage = $this->bdd->prepare("SELECT PA FROM personnage WHERE Id = ?");
            $requetePersonnage->execute([$idPersonnage]);
            $statsPersonnage = $requetePersonnage->fetch(PDO::FETCH_ASSOC);

            // Récupérer la vie actuelle du monstre depuis la base de données
            $requeteMonstre = $this->bdd->prepare("SELECT Pv FROM monstre WHERE Id = ?");
            $requeteMonstre->execute([$idMonstre]);
            $vieMonstre = $requeteMonstre->fetchColumn();

            $degats = $statsPersonnage['PA'];

            // Calcul des dégâts
            $nouvelleVieMonstre = $vieMonstre - $degats;

            // Mise à jour de la BDD
            $requeteUpdate = $this->bdd->prepare("UPDATE monstre SET Pv = ? WHERE Id = ?");
            $requeteUpdate->execute([$nouvelleVieMonstre, $idMonstre]);

            return $degats;
        } catch (PDOException $e) {
            echo "Erreur lors de l'attaque du monstre: " . $e->getMessage();
            return 0;
        }
    }

    public function attaquerPersonnage($idMonstre, $idPersonnage, $defense = false) {
        try {
            //Récupération des statistiques d'attaque du monstre depuis la base de données
            $requeteMonstre = $this->bdd->prepare("SELECT PA FROM monstre WHERE Id = ?");
            $requeteMonstre->execute([$idMonstre]);
            $statsMonstre = $requeteMonstre->fetch(PDO::FETCH_ASSOC);
    
            //Récupération des points de défense du personnage depuis la base de données
            $requetePersonnage = $this->bdd->prepare("SELECT PD FROM personnage WHERE Id = ?");
            $requetePersonnage->execute([$idPersonnage]);
            $statsPersonnage = $requetePersonnage->fetch(PDO::FETCH_ASSOC);
    
            //Calcul des dégâts en prenant en compte les points de défense
            $degats = max(0, $statsMonstre['PA'] - ($defense ? $statsPersonnage['PD'] : 0));
    
            //Calcul des dégâts pour set la vie par la suite
            $requeteViePersonnage = $this->bdd->prepare("SELECT Pv FROM personnage WHERE Id = ?");
            $requeteViePersonnage->execute([$idPersonnage]);
            $viePersonnage = $requeteViePersonnage->fetchColumn();
            $nouvelleViePersonnage = max(0, $viePersonnage - $degats);
    
            $requeteUpdate = $this->bdd->prepare("UPDATE personnage SET Pv = ? WHERE Id = ?");
            $requeteUpdate->execute([$nouvelleViePersonnage, $idPersonnage]);
    
            return $degats;
        } catch (PDOException $e) {
            echo "Erreur lors de l'attaque du personnage: " . $e->getMessage();
            return 0;
        }
    }

    public function demanderActionJoueur() {
        //Attaque ou se défends
        echo "Tour du joueur. Choisissez votre action (attaquer/se défendre): ";
        $action = trim(readline());
        return strtolower($action);
    }

    public function EstMortPersonnage($idPersonnage) {
        try {
            //Récupére la vie actuelle du personnage depuis la base de données
            $requetePersonnage = $this->bdd->prepare("SELECT Pv FROM personnage WHERE Id = ?");
            $requetePersonnage->execute([$idPersonnage]);
            $viePersonnage = $requetePersonnage->fetchColumn();
    
            //Vérifie si la vie du personnage est inférieure ou égale à zéro
            return $viePersonnage <= 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de la mort du personnage: " . $e->getMessage();
            return false; 
        }
    }

    public function EstMortMonstre($idMonstre) {
        try {
            //Récupére la vie actuelle du monstre depuis la base de données
            $requeteMonstre = $this->bdd->prepare("SELECT Pv FROM monstre WHERE Id = ?");
            $requeteMonstre->execute([$idMonstre]);
            $vieMonstre = $requeteMonstre->fetchColumn();
    
            //Vérifie si la vie du monstre est inférieure ou égale à zéro
            return $vieMonstre <= 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de la mort du monstre : " . $e->getMessage();
            return false;
        }
    }
    
    public function tourDeCombat($idPersonnage, $idMonstre, $tour) {
        //Vérifie si c'est le tour du joueur
        if ($tour % 2 == 1) {
            $action = $this->demanderActionJoueur();
            if ($action == 'attaquer') {
                $degats = $this->attaquerMonstre($idPersonnage, $idMonstre);
                echo "Vous avez infligé $degats points de dégâts au monstre.";
    
                //Vérifie si le monstre est mort après l'attaque
                if ($this->EstMortMonstre($idMonstre)) {
                    echo "Le monstre est mort. Le combat est terminé, Vous avez gagné.";
                    return;
                }
            }
            if ($action == 'defendre') {
                //Le joueur se défend, réduit les dégâts du monstre
                $degats = $this->attaquerPersonnage($idMonstre, $idPersonnage, true);
                echo "Vous vous défendez et avez réduit les dégâts reçus à $degats.";
                
                //Vérifie si le monstre est mort après l'attaque
                if ($this->EstMortMonstre($idMonstre)) {
                    echo "Le monstre est mort. Le combat est terminé, Vous avez gagné.";
                    return;
                }
            } else  {
            // Tour du monstre
            $degats = $this->attaquerPersonnage($idMonstre, $idPersonnage, false);
            echo "Le monstre vous a infligé $degats points de dégâts.";
    
            //Vérifie si le personnage est mort après l'attaque du monstre
            if ($this->EstMortPersonnage($idPersonnage)) {
                echo "Vous êtes mort. Le combat est terminé.";
                return;
            }
        }
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
        //Ajout des niveaux (utilisé qu'au début afin de remplir un minimum la base de données)
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