<?php
//Connexion à la BDD avec PDO
    try{
        $hote = "127.0.0.1";
        $utilisateur = "root";
        $motDePasse = "0zIOU8iwgW3658EshvUD";
        $nomDeLaBase = "examenphp";
        //création instance de PDO pour la connexion à la BDD
        $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur,$motDePasse);
        //configuration de PDO pour générer des exceptions en cas d'erreur
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        //si echec, affiche message erreur
        echo "Erreur de connexion à la base de données : ".$e->getMessage();
        //arrête script
        die();
    }

?>