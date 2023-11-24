<?php
include("config.php");
include("Personnage.php");
include("PersonnageDAO.php");

$DAO = new DAO($connexion);

$choix=readline("Que voulez faire ?\n 1. Ajouter un utilisateur\n 2. Lister les personnages \n 3. Jouer \n 4. Quitter \n");

switch ($choix){
    case "1":
        // $nom=readline("Entrer le nom : ");
        // $PV=readline("Entrer le PV : ");
        // $PA=readline("Entrer le PA : ");
        // $PD=readline("Entrer le PD : ");
        // $exp=readline("Entrer le exp : ");
        //$monstre=new Monstre ($nom,$PV,$PA,$PD,$exp,100);
        $DAO->attaquerMonstre(1,1);
        //$Perso = new Personnages($nom,$PV,$PA,$PD,$exp,1);
        //$DAO->ajouterPersonnage($Perso);
        echo "Le personnage a bien été ajouté. \n";
        echo "Liste des personnages : \n";
        $personnages = $DAO->listerPersonnage();
        // print_r($personnages);
        if ($personnages){
            foreach($personnages as $e){
                echo "Id : ".$e['Id']."\n";
                echo 'Nom : '.$e['Nom']."\n";
                echo 'PV : '.$e['PV']."\n";
                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
            }
        }

        break;
    case"2":
        echo "Liste des personnages : \n";
        $personnages = $DAO->listerPersonnage();
        // print_r($personnages);
        if ($personnages){
            foreach($personnages as $e){
                echo "Id : ".$e['Id']."\n";
                echo 'Nom : '.$e['Nom']."\n";
                echo 'PV : '.$e['PV']."\n";
                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
            }
        }
        break;

    case"3":

        //Manque la création de la salle permettant d'initialiser les valeurs ci-dessous
        $idPersonnage = 1;
        $idMonstre = 1;
        $tour = 1;
        
        // Début du combat
        while (true) {
            echo ($tour);
            $DAO->tourDeCombat($idPersonnage, $idMonstre, $tour);
            $tour++;
        
            // Conditions de fin de combat (par exemple, si la vie du personnage ou du monstre atteint zéro)
            if ($tour==5) {
                echo("Fin du combat");
                break;

            }
        }
        
        break;
    case"4":
        echo "Au revoir ! ";
        break;
    default:
    echo "Crash du jeu ! ";
        break;

}
?>