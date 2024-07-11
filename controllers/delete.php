<?php

require_once '../models/eleves.php';

// Précisez le content-type afin que l'API le lise au format correct
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $database = new Database();
  $db = $database->getConnexion();

  $eleve = new Eleves($db);
  $data = json_decode(file_get_contents("php://input", false, null, 0, 10000));

  if (!empty($data->id)) {
    $eleve->id = intval($data->id);

    $result = $eleve->delete();
    if ($result) {
      echo json_encode(["message" => "Elève supprimé avec succès"]);
    } else {
      echo json_encode(["message" => "La suppression de l'élève a échouée"]);
    }
  } else {
    echo json_encode(["message" => "Les données ne sont pas complètes"]);
  }
} else {
  echo json_encode(["message" => "Méthode pas autorisée"]);
}
