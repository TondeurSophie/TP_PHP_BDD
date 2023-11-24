<?php

//permet d'appeler les fichiers associer à ce projet
include("config.php");
include("classes.php");
include("DAO.php");


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
        $PV=readline("Entrer le PV : ");
        $PA=readline("Entrer le PA : ");
        $PD=readline("Entrer le PD : ");
        $exp=readline("Entrer le exp : ");
        //création de l'objet Personnage avec les infos précédentes
        $Perso = new Personnages("",$nom,$PV,$PA,$PD,$exp,1);
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
                echo 'Points de Défence : '.$e['PD']."\n";
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
        //Affichage
        if ($personnages){
            foreach($personnages as $e){
                echo "Id : ".$e['Id']."\n";
                echo 'Nom : '.$e['Nom']."\n";
                echo 'Points de Vie : '.$e['PV']."\n";
                echo 'Points Attaque : '.$e['PA']."\n";
                echo 'Points de Défence : '.$e['PD']."\n";
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
                echo 'Points de Défence : '.$e['PD']."\n";
                echo 'Expérience donne : '.$e['exp']."\n";
                echo 'Niveau : '.$e['niveau']."\n";
                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
            }
        }
        $id= readline("Choisissez votre personnage en fonction de l'id :");
        $personnages = $DAO ->monPerso($personnages,$id);

            //Jeu

            $salle = rand(1,10);
            echo $salle;

            if (5 >= $salle && $salle >= 1){
                echo "C'est l'heure de combattre \n";
                //Manque la création de la salle permettant d'initialiser les valeurs ci-dessous
                $idPersonnage = $id; //remplacer par l'id du choix personnage
                $idMonstre = 1; //faire un aléatoire sur le choix du monstre
                $tour = 1;
        
                //Début du combat
                while (true) {
                    $DAO->tourDeCombat($idPersonnage, $idMonstre, $tour);
                    $tour++;
                    if($DAO->tourDeCombat($idPersonnage, $idMonstre, $tour)==false){
                    break;
                    }
                }
                echo("\n Fin du combat");
            }
            if (10>= $salle && $salle > 7 ){

                //Les enigmes fonctionnent. On ne sait pas pourquoi mais quelques fois, cela ne fonctionne pas.
                //on lance une première fois, àa fonctionne, on relance ça ne fonctionne plus ou inversement. 

                echo "Epreuve : Enigmes \n";
                $enigme=$DAO->EnigmeAléatoire();
                if ($enigme){
                    foreach($enigme as $e){
                        echo "Id : ".$e['Id']."\n";
                        echo 'Question : '.$e['Question']."\n";
                        echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
                    }
                }
            }
                // $reponse=readline("Votre réponse : ");
                // if ($reponse == $enigme.$e['Reponse']){
                //     echo"Bien joué";
                // }
                // else{
                //     echo "Game Over";
                // }
            if (7 >= $salle && $salle >5  ){
                echo "Le marchand vous propose un échange \n";
                $echange=readline("Voulez vous faire un échange ? (Oui/Non) ");
                switch($echange){
                    case"Non" :
                        echo "Le marchand est parti";
                        break;
                        
                    case "Oui":
                        // $personnages=$DAO->listerMarchand();
                        // if ($personnages){
                        //     foreach($personnages as $e){
                        //         echo "Id : ".$e['Id']."\n";
                        //         echo 'Nom : '.$e['Nom']."\n";
                        //         echo 'Points de Vie : '.$e['PV']."\n";
                        //         echo 'Points Attaque : '.$e['PA']."\n";
                        //         echo 'Points de Défence : '.$e['PD']."\n";
                        //         echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
                        //     }
                        // }
                        // le marchand donne un nom aléatoire des objets = id_inventaire
                        echo "Le marchand veut : \n";
                        $personnage=$DAO->AléatoireMarchand();
                        print_r($personnage);
                        if ($personnage){
                            foreach($personnage as $e){
                                echo "Id : ".$e['Id']."\n";
                                echo 'Nom : '.$e['Nom']."\n";
                                echo 'Points de Vie : '.$e['Pv']."\n";
                                echo 'Points Attaque : '.$e['Pa']."\n";
                                echo 'Points de Défence : '.$e['Pd']."\n";
                                echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
                            }
                        }
                        $avoir=readline("Avez-vous l'objet en question ? \n");
                        if ($avoir == "Oui"){
                            echo "Choix des objets :\n ";
                            $personnages=$DAO->listerInventaire();
                            $id_inventaire=readline("Quel objet échangez vous ? (Id)");
                            $personnages=$DAO->listerMarchand();
                            if ($personnages){
                                foreach($personnages as $e){
                                    echo "Id : ".$e['Id']."\n";
                                    echo 'Nom : '.$e['Nom']."\n";
                                    echo 'Points de Vie : '.$e['PV']."\n";
                                    echo 'Points Attaque : '.$e['PA']."\n";
                                    echo 'Points de Défence : '.$e['PD']."\n";
                                    echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
                                }
                            }
                            $id_marchand=readline("Quel objet du marchand voulez-vous ? (Id)");
                            $choix=readline("Voulez-vous continuer ? (Oui/Non)");
                            if ($choix == "Oui"){
                                $personnages=$DAO->supprimerObjetInventaire($id_inventaire);
                                $personnages=$DAO->ajouterInventaire($id_marchand);
                                $personnages=$DAO->ajouterInventaireMarchand($id_inventaire);
                            }
                            else{
                                echo "Vous n'avez pas ce que le marchand désire";
                            }
                        }           
                        break;
                    }
                }
        break;

    //Quitter
    case"4":
        echo "Au revoir ! ";
        break;
    default:
        echo "Au revoir ! ";
        break;
}
?>