<?php
require_once('../config/database.php');

class Cours
{
  private $connexion = null;
  private $table = "cours";

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
}
