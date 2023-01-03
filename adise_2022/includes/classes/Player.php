<?php 
class Player {

   private $con, $id;

   public function __construct($con, $id) {
      $this->con = $con;
      $this->id = $id;
   }

   public function getId() {
      return $this->id;
   }

   public function getName() {
      $playerQuery = $this->con->prepare("SELECT name FROM players WHERE id = :playerId");
      $playerQuery->bindValue(":playerId", $this->id);
      $playerQuery->execute();

      $player = $playerQuery->fetch(PDO::FETCH_ASSOC);
      
      return $player["name"];
   }

   public function getTileIds() {
      $query = $this->con->prepare("SELECT id FROM tiles WHERE player = :playerId
                                    ORDER BY plays DESC");
      $query->bindValue(":playerId", $this->id);
      $query->execute();

      $array = array();

      while($row = $query->fetch(PDO::FETCH_ASSOC)) {
         array_push($array, $row["id"]);
      }

      return $array;
   }
}
?>