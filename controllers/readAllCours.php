<?php

require_once '../models/cours.php';

// Précisez le content-type afin que l'API le lise au format correct
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $database = new Database();
  $db = $database->getConnexion();

  $cours = new Cours($db);
  $datas = $cours->readAll();

  if ($datas->rowCount() > 0) {
    $data = [];

    $data = $datas->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
    http_response_code(200);
  } else {
    echo json_encode(["message" => "Aucune donnée n'a été envoyée"]);
    http_response_code(500);
  }
} else {
  echo json_encode(["message" => "Méthode pas autorisée"]);
  http_response_code(405);
}
