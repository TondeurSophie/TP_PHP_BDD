<?php
try {
    //Données de connexion
    $hote = "localhost";
    $utilisateur = "azerty";
    $motDePasse = "mdp";
    $nomDeLaBase = "DragonExamen";
    //Connexion à la base de données
    $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);
    
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo"Connection Réussi";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}
    

?>