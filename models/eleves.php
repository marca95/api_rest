<?php
require_once('../config/database.php');

class Eleves
{
  private $connexion = null;
  public $id;
  public $nom;
  public $prenom;
  public $annee;
  private $table = "eleves";

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

  public function create()
  {
    $sql = "INSERT INTO $this->table(nom, prenom, annee) VALUES (:nom, :prenom, :annee)";
    $req = $this->connexion->prepare($sql);
    $params = ([
      ":nom" => $this->nom,
      ":prenom" => $this->prenom,
      ":annee" => $this->annee
    ]);

    if ($req->execute($params)) {
      return true;
    } else {
      return false;
    }
  }

  public function update()
  {
    $sql = "UPDATE $this->table SET nom=:nom, prenom=:prenom, annee=:annee WHERE id=:id";
    $req = $this->connexion->prepare($sql);
    $params = ([
      ":nom" => $this->nom,
      ":prenom" => $this->prenom,
      ":annee" => $this->annee,
      ":id" => $this->id
    ]);

    if ($req->execute($params)) {
      return true;
    } else {
      return false;
    }
  }

  public function delete()
  {
    $sql = "DELETE FROM $this->table WHERE id=:id";
    $req = $this->connexion->prepare($sql);

    if ($req->execute(array(":id" => $this->id))) {
      return true;
    } else {
      return false;
    }
  }
}
