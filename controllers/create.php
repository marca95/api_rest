<?php

require_once '../models/eleves.php';

// Précisez le content-type afin que l'API le lise au format correct
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $database = new Database();
  $db = $database->getConnexion();

  $eleve = new Eleves($db);

  /**
   * php://input, permet de lire les données brutes depuis le corps de la requete HTTP,
   * utile pour obtenir des données JSON envoyées via une requete POST, PUT ou PATCH 
   */

  $data = json_decode(file_get_contents("php://input", false, null, 0, 10000));

  if (!empty($data->nom) && !empty($data->prenom) && !empty($data->annee)) {
    $eleve->nom = htmlspecialchars($data->nom, ENT_QUOTES, 'UTF-8');
    $eleve->prenom = htmlspecialchars($data->prenom, ENT_QUOTES, 'UTF-8');
    $eleve->annee = intval($data->annee);

    $result = $eleve->create();
    if ($result) {
      echo json_encode(["message" => "Elève ajouté avec succès"]);
    } else {
      echo json_encode(["message" => "L'ajout de l'élève a échouéx"]);
    }
  } else {
    echo json_encode(["message" => "Les données ne sont pas complètes"]);
  }
} else {
  echo json_encode(["message" => "Méthode pas autorisée"]);
}
