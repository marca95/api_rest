<?php

class Database
{
  private $host = "localhost";
  private $dbname = "ecole";
  private $username = "root";
  private $password = "";

  public function getConnexion()
  {
    $conn = null;

    try {
      $conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "Erreur de connexion :" . $e->getMessage();
    }

    return $conn;
  }
}
