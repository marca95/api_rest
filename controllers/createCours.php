<?php

require_once '../models/cours.php';

// Précisez le content-type afin que l'API le lise au format correct
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $database = new Database();
  $db = $database->getConnexion();

  $cours = new cours($db);

  /**
   * php://input, permet de lire les données brutes depuis le corps de la requete HTTP,
   * utile pour obtenir des données JSON envoyées via une requete POST, PUT ou PATCH 
   */

  $data = json_decode(file_get_contents("php://input", false, null, 0, 10000));

  if (!empty($data->titre)) {
    $cours->titre = htmlspecialchars($data->titre, ENT_QUOTES, 'UTF-8');

    // Vérifier si le cours existe déjà
    $checkQuery = $db->prepare("SELECT * FROM cours WHERE titre = :titre");
    $checkQuery->bindParam(':titre', $cours->titre);
    $checkQuery->execute();

    if ($checkQuery->rowCount() > 0) {
      echo json_encode(["message" => "Le cours existe déjà dans la base de données"]);
    } else {
      $result = $cours->create();
      if ($result) {
        echo json_encode(["message" => "Cours ajouté avec succès"]);
        http_response_code(201);
      } else {
        echo json_encode(["message" => "L'ajout du cours a échoué"]);
        http_response_code(500);
      }
    }
  } else {
    echo json_encode(["message" => "Les données ne sont pas complètes"]);
  }
} else {
  echo json_encode(["message" => "Méthode non autorisée"]);
  http_response_code(405);
}
