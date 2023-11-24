<?php

//création d'une classe DAO. Elle permet d'accèder aux données
class DAO{
    //création d'une variable $bdd en private car on ne l'utilise pas en dehors de la classe
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    //fonction qui permet d'ajouter un personnage
    public function ajouterPersonnage(Personnages $personnages) {
        try {
            //Requête SQL permettant d'insérer un personnage dans la BDD avec ses attributs 
            $requete = $this->bdd->prepare("INSERT INTO personnage (nom, PV,PA,PD,exp_donne,niveau) VALUES (?,?,?,?,?,?)");
            // création du personnage avec les valeurs de l'objet Personnages
            $requete->execute([$personnages->getNom(), $personnages->getPV(),$personnages->getPA(),$personnages->getPD(),$personnages->getexp(),$personnages->getNiveau()]);
            echo "Le personnage a bien été ajouté. \n";
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

    //fonction qui permet de lister les personnages existant
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

    public function ajouterMonstre(Monstre $monstre) {
        //Ajout du monstre dans la base de données
        try {
            $requete = $this->bdd->prepare("INSERT INTO monstre (Nom, Pv, PA, PD, exp_done) VALUES (?, ?, ?, ?, ?)");
            $requete->execute([$monstre->getNom(), $monstre->getPV(), $monstre->getPa(),$monstre->getPd(),$monstre->getExpDonne()]);
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
            $requete = $this->bdd->prepare("SELECT * FROM salle ");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des salles: " . $e->getMessage();
            return [];
        }
    }

    public function monPerso($personnages,$id){
        try{
            //requete qui permet de récupérer toutes les infos du personnage choisi en fonction de son id
            $requete=$this->bdd->prepare("SELECT * FROM personnage WHERE id = ?");
            $requete->execute([$id]);
            //on met les infos de  notre personnage dans un tableau
            $info=$requete->fetch();
            echo "Mon perso : \n";
            //affichage des informations
            echo ("Nom : ".$info ["Nom"]."\n"."PV : ".$info["PV"]."\n"."PA : ".$info["PA"]."\n"."PD : ".$info["PD"]."\n"."Expérience donne : ".$info["exp_donne"]."\n"."Niveau : ".$info["niveau"]."\n");
            return true;
        }catch (PDOException $e) {
            echo "Erreur d'affichage monPerso: " . $e->getMessage();
            return false;
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

    public function listerMarchand() {
        //Liste des objets que propose le marchant (limite à 5 objets)
        try {
            $requete = $this->bdd->prepare("SELECT * from marchand order by rand() limit 5;");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des objets : " . $e->getMessage();
            return [];
        }
    }

    public function listerInventaire(){
        //Liste des objets/armes du joueur
        try {
            $requete = $this->bdd->prepare("SELECT * from inventaire");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des objets : " . $e->getMessage();
            return [];
        }
    }

    //fonction qui permet de retirer les objets de l'inventaire durant l'échange avec le marchant
    public function supprimerObjetInventaire($id_inventaire){
        try{
            $requete = $this->bdd->prepare("DELETE FROM inventaire WHERE id = ?");
            $requete -> execute([$id_inventaire]);
            return true;
        }
        catch(PDOException $e){
            echo "Erreur de suppression de l'objet de l'inventaire : ".$e->getMessage();
            return false;
        }
    }
    
    //on ajoute un objet du marchand dans notre inventaire
    public function ajouter(Inventaire $inventaire){
        //Ajout d'un objet dans la base de données
        try {
            $requete2 = $this->bdd->prepare("INSERT INTO inventaire (Nom, PV, PA, PD) VALUES (?, ?, ?, ?)");
            $requete2->execute([$inventaire->getNom(), $inventaire->getPV(), $inventaire->getPA(), $inventaire->getPD()]);
            
        } catch (PDOException $e) {
            echo "Erreur d'ajout de l'objet dans l'inventaire: " . $e->getMessage();
            return false;
        }
    } 
    //fonction qui permet d'ajouter à notre inventaire l'objet du marchand
    //on récupère tout notre objet
    public function ajouterInventaire($id_marchand) {
        try{
            $requete = $this->bdd->prepare("SELECT * FROM marchand WHERE id = ?");
            $requete->execute([$id_marchand]);
            // $requete->execute([$inventaire->getNom(), $inventaire->getPV(), $inventaire->getPA(), $inventaire->getPD()]);
            $info=$requete->fetch();
            echo ("Nom : ".$info ["Nom"]."\n"."PV : ".$info["PV"]."\n"."PA : ".$info["PA"]."\n"."PD : ".$info["PD"]."\n");
            
            $Inventaire=new Inventaire($info ["Nom"],$info["PV"],$info["PA"],$info["PD"]);
            
            //on ajoute dans notre inventaire
            $this->ajouter($Inventaire);
            
            return true;
        }catch (PDOException $e) {
            echo "Erreur d'ajout de l'objet dans l'inventaire: " . $e->getMessage();
            return false;
        }
    }

    //on ajoute un objet du marchand dans notre inventaire
    public function ajouterObjetMarchand(Marchand $marchand){
        //Ajout d'un objet dans la base de données
        try {
            $requete2 = $this->bdd->prepare("INSERT INTO inventaire (Nom, PV, PA, PD) VALUES (?, ?, ?, ?)");
            $requete2->execute([$marchand->getNom(), $marchand->getPV(), $marchand->getPA(), $marchand->getPD()]);
            
        } catch (PDOException $e) {
            echo "Erreur d'ajout de l'objet dans l'inventaire du marchand : " . $e->getMessage();
            return false;
        }
    } 
    //fonction qui permet d'ajouter à notre inventaire l'objet du marchand
    //on récupère tout notre objet
    public function ajouterInventaireMarchand($id_inventaire) {
        try{
            $requete = $this->bdd->prepare("SELECT * FROM inventaire WHERE id = ?");
            $requete->execute([$id_inventaire]);
            // $requete->execute([$inventaire->getNom(), $inventaire->getPV(), $inventaire->getPA(), $inventaire->getPD()]);
            $info=$requete->fetch();
            echo ("Nom : ".$info ["Nom"]."\n"."PV : ".$info["PV"]."\n"."PA : ".$info["PA"]."\n"."PD : ".$info["PD"]."\n");
            
            $Marchand=new Marchand($info ["Nom"],$info["PV"],$info["PA"],$info["PD"]);
            
            //on ajoute dans notre Marchand
            $this->ajouterObjetMarchand($Marchand);
            
            return true;
        }catch (PDOException $e) {
            echo "Erreur d'ajout de l'objet dans l'inventaire du marchand: " . $e->getMessage();
            return false;
        }
        
    }

    //fonction qui crée la demande du marchand 
    public function AléatoireMarchand(){
        try{
            $requete=$this->bdd->prepare("SELECT * from arme WHERE Id = round(rand() * 9) + 1");
            $requete->execute();
            $info=$requete->fetch();
            // echo ("Id : ".$info ["Id"]."\n"."Nom : ".$info ["Nom"]."\n"."PV : "."\n"."Niveau requis : ".$info ["Niveau_requis"]."\n"."PV : ".$info["Pv"]."\n"."PA : ".$info["Pa"]."\n"."PD : ".$info["Pd"]."\n");
            print_r($info);
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            echo "Erreur d'ajout de l'objet dans l'inventaire du marchand: " . $e->getMessage();
            return false;
        }
    }

    //fonction qui permet de mettre une question aléatoire et de répondre à la question
    public function EnigmeAléatoire(){
        try{
            $requete=$this->bdd->prepare("SELECT * FROM questions WHERE Id = round(rand() * 9) + 1 ");
            $requete->execute();
            $question=$requete->fetch();
            // echo ("Question : ".$question['Question']."\n");
            print_r($question['Question']);
            $reponse=readline("Votre réponse : ");
            if($question['Reponse'] == $reponse){
                echo"Bien joué";
            }else{
                echo "Game Over";
                exit;
            }
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e) {
            echo "Erreur d'ajout de l'objet dans l'inventaire du marchand: " . $e->getMessage();
            return false;
        }
    }

    
}





?>