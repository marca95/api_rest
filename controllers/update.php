<?php

require_once '../models/eleves.php';

// Précisez le content-type afin que l'API le lise au format correct
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $database = new Database();
  $db = $database->getConnexion();

  $eleve = new Eleves($db);
  $data = json_decode(file_get_contents("php://input", false, null, 0, 10000));

  if (!empty($data->id) && !empty($data->nom) && !empty($data->prenom) && !empty($data->annee)) {
    if (is_string($data->nom) && is_string($data->prenom) && is_integer($data->annee) && is_integer($data->id)) {
      $eleve->id = intval($data->id);
      $eleve->nom = htmlspecialchars($data->nom);
      $eleve->prenom = htmlspecialchars($data->prenom);
      $eleve->annee = intval($data->annee);

      $result = $eleve->update();
      if ($result) {
        echo json_encode(["message" => "Elève modifié avec succès"]);
        http_response_code(200);
      } else {
        echo json_encode(["message" => "La modification de l'élève a échouée"]);
        http_response_code(500);
      }
    } else {
      echo json_encode(["message" => "Format d'une donnée incorrect"]);
    }
  } else {
    echo json_encode(["message" => "Les données ne sont pas complètes"]);
  }
} else {
  echo json_encode(["message" => "Méthode pas autorisée"]);
  http_response_code(405);
}
