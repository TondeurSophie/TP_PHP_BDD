<?php
//permet de se connecter à la BDD avec PDO
    try{
        //on rentre nos informations
        $hote = "127.0.0.1";
        $utilisateur = "root";
        $motDePasse = "password";
        $nomDeLaBase = "ExamenPhp";

        //création d'une variable connexion, nous permettant avec PDO de nous connecter à la BDD
        $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur,$motDePasse);
        //Gestion d'erreur de la connexion
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        //si echec de la connexion, affiche un message d'erreur
        echo "Erreur de connexion à la base de données : ".$e->getMessage();
        //arrête le script
        die();
    }

?>