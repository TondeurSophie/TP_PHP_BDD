<?php
include("config.php");
include("Personnage.php");
include("PersonnageDAO.php");

$DAO = new DAO($connexion);

//l'utilisateur choisi ce qu'il veut faire
$choix=readline("Que voulez faire ?
1. Ajouter un utilisateur
2. Lister les personnages 
3. Jouer 
4. Quitter \n");

//en fonction du choix précédent :
switch ($choix){
    //Ajouter un personnage
    case "1":
        $nom=readline("Entrer le nom : ");
    
        //création de l'objet Personnage avec les infos précédentes
        $Perso = new Personnages($nom,30,5,10,0,1);
        $DAO->ajouterPersonnage($Perso);
        
        echo "Liste des personnages : \n";
        $personnages = $DAO->listerPersonnage();
        // print_r($personnages);
        //Affichage
        if ($personnages){
            foreach($personnages as $e){
                echo "Id : ".$e['Id']."\n";
                echo 'Nom : '.$e['Nom']."\n";
                echo 'Points de Vie : '.$e['PV']."\n";
                echo 'Points Attaque : '.$e['PA']."\n";
                echo 'Points de Défense : '.$e['PD']."\n";
                echo 'Expérience donne : '.$e['exp']."\n";
                echo 'Niveau : '.$e['niveau']."\n";
                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
            }
        }
        break;

    //Liste des personnages
    case"2":
        popen('cls','w');
        echo "Liste des personnages : \n";
        $personnages = $DAO->listerPersonnage();
        // print_r($personnages);
        if ($personnages){
            foreach($personnages as $e){
                echo "Id : ".$e['Id']."\n";
                echo 'Nom : '.$e['Nom']."\n";
                echo 'Points de Vie : '.$e['PV']."\n";
                echo 'Points Attaque : '.$e['PA']."\n";
                echo 'Points de Défense : '.$e['PD']."\n";
                echo 'Expérience donne : '.$e['exp']."\n";
                echo 'Niveau : '.$e['niveau']."\n";
                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
            }
        }
        break;

    //Jouer (combat/énigmes/marchand)
    case"3":
            popen('cls','w');
            echo "Liste des personnages : \n";
            $personnages = $DAO->listerPersonnage();
            if ($personnages){
                foreach($personnages as $e){
                    echo "Id : ".$e['Id']."\n";
                    echo 'Nom : '.$e['Nom']."\n";
                    echo 'Points de Vie : '.$e['PV']."\n";
                    echo 'Points Attaque : '.$e['PA']."\n";
                    echo 'Points de Défense : '.$e['PD']."\n";
                    echo 'Expérience donne : '.$e['exp']."\n";
                    echo 'Niveau : '.$e['niveau']."\n";
                    echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
                }
            }
            $id= readline("Choisissez votre personnage en fonction de l'id :");
            $personnages = $DAO ->monPerso($personnages,$id);
            $continue="Oui";
            $verif = true;
            while($continue=="Oui"){

            
            // Jeu
            while ($verif) {
                
                $salle = rand(1, 10);
    
                if (5 >= $salle && $salle >= 1) {
                    echo "C'est l'heure de combattre \n";
                    $idPersonnage = $id;
                    $idMonstre = rand(1, 3);
                    $tour = 1;
    
                    // Début du combat
                    $issu = true;
    
                    while ($issu) {
                        $issu = $DAO->tourDeCombat($idPersonnage, $idMonstre, $tour);
                        $tour++;
                    }
                    $continue = readline("Voulez-vous continuer ? (Oui/Non) ");
                    if ($continue === "Non") {
                        $verif=false;
                        break;
                    }
    
                    // À ce stade, le combat est terminé
                    echo "\n Fin du combat";
                }
    
                if (10 >= $salle && $salle > 7) {
                    // Énigme
                    echo "Epreuve : Enigmes \n";
                    $enigmeReussie = $DAO->EnigmeAléatoire();
    
                    if ($enigmeReussie) {
                        echo "Épreuve réussie !\n";
                        $continue = readline("Voulez-vous continuer ? (Oui/Non) ");
                        if ($continue === "Non") {
                            $verif=false;
                            break;
                        }
                    } else {
                        echo "Épreuve échouée. Game Over.\n";
                        exit;
                    }
                }
    
                $continue = readline("Voulez-vous continuer ? (Oui/Non) ");
                if ($continue === "Non") {
                    $verif=false;
                    break;
                }
            }
        }
            break;
    //Quitter
    case"4":
        echo "Au revoir ! ";
        break;
    default:
        echo "Crash ! ";
        break;

}    
?>