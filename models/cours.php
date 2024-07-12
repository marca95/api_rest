<?php
require_once('../config/database.php');

class Cours
{
  private $connexion = null;
  private $table = "cours";
  public $titre;
  public $id;

  public function __construct($db)
  {
    if ($this->connexion == null) {
      $this->connexion = $db;
    }
  }

  public function readAll()
  {
    $sql = "SELECT * FROM $this->table";
    $req = $this->connexion->query($sql);

    return $req;
  }

  // Création méthode pour une valeur unique dans la BD

  public function create()
  {
    $sql = "INSERT INTO $this->table(titre) VALUES (:titre)";
    $req = $this->connexion->prepare($sql);
    $req->bindParam(":titre", $this->titre);

    if ($req->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
