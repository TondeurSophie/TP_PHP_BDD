<?php

//permet d'appeler les fichiers associer à ce projet
include("config.php");
include("classes.php");
include("DAO.php");


$DAO = new DAO($connexion);

$choix=readline("Que voulez faire ?
1. Ajouter un utilisateur
2. Lister les personnages 
3. Jouer 
4. Quitter \n");

switch ($choix){
    case "1":
        $nom=readline("Entrer le nom : ");
        $PV=readline("Entrer le PV : ");
        $PA=readline("Entrer le PA : ");
        $PD=readline("Entrer le PD : ");
        $exp=readline("Entrer le exp : ");
        $Perso = new Personnages("",$nom,$PV,$PA,$PD,$exp,1);
        $DAO->ajouterPersonnage($Perso);
        echo "Le personnage a bien été ajouté. \n";
        echo "Liste des personnages : \n";
        $personnages = $DAO->listerPersonnage();
        // print_r($personnages);
        if ($personnages){
            foreach($personnages as $e){
                echo "Id : ".$e['Id']."\n";
                echo 'Nom : '.$e['Nom']."\n";
                echo 'Points de Vie : '.$e['PV']."\n";
                echo 'Points Attaque : '.$e['PA']."\n";
                echo 'Points de Défence : '.$e['PD']."\n";
                echo 'Expérience donne : '.$e['exp_donne']."\n";
                echo 'Niveau : '.$e['niveau']."\n";
                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
            }
        }

        break;
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
                echo 'Points de Défence : '.$e['PD']."\n";
                echo 'Expérience donne : '.$e['exp_donne']."\n";
                echo 'Niveau : '.$e['niveau']."\n";
                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
            }
        }
        break;

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
                echo 'Points de Défence : '.$e['PD']."\n";
                echo 'Expérience donne : '.$e['exp_donne']."\n";
                echo 'Niveau : '.$e['niveau']."\n";
                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
            }
        }
        $id= readline("Choisissez votre personnage en fonction de l'id :");
        $personnages = $DAO ->monPerso($personnages,$id);
        break;

    case"4":
        echo "Au revoir ! ";
        break;
    default:
        echo "Au revoir ! ";
        break;

}



?>