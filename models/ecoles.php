<?php

class Gymnase
{
  private $connexion = null;
  private $table = "gymnase";

  public $id;
  public $name;
  public $address;
  public $team;
  public $member;
  public $lesson;

  public function __construct($db)
  {
    if ($this->connexion == null) {
      $this->connexion = $db;
    }
  }

  public function readAll()
  {
    $sql = "SELECT * FROM $this->table";
    $req = $this->connexion->prepare($sql);
    $req->execute();

    return $req;
  }
}
