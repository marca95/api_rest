<?php
require_once('../config/database.php');

class Cours_eleves
{
  private $connexion = null;
  private $table = "cours_eleves";

  public function __construct($db)
  {
    if ($this->connexion == null) {
      $this->connexion = $db;
    }
  }

  public function readAllCoursEleves()
  {
    $sql = "SELECT 
    eleves.id AS eleve_id, 
    eleves.nom, 
    eleves.prenom, 
    eleves.annee, 
    GROUP_CONCAT(cours.titre SEPARATOR ', ') AS cours_titres
FROM 
    $this->table 
INNER JOIN 
    cours ON cours_eleves.cours_id = cours.id 
INNER JOIN 
    eleves ON cours_eleves.eleve_id = eleves.id 
GROUP BY 
    eleves.id";

    $req = $this->connexion->query($sql);

    return $req;
  }
}
