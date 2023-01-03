<?php 
class Variation {

   private $con, $id, $title, $playerId, $artworkPath;

   public function __construct($con, $id) {
      $this->con = $con;
      $this->id = $id;

      $query = $this->con->prepare("SELECT * FROM variations WHERE id = :id");
      $query->bindValue(":id", $this->id);

      $query->execute();

      $variation = $query->fetch(PDO::FETCH_ASSOC);

      $this->title = $variation["title"];
      $this->playerId = $variation["player"];
      $this->artworkPath = $variation["gamePath"];
   }

   public function getTitle() {
      return $this->title;
   }

   public function getPlayer() {
      return new Player($this->con, $this->playerId);
   }

   public function getArtworkPath() {
      return $this->artworkPath;
   }

   public function getNumberOfTiles() {
      $query = $this->con->prepare("SELECT id FROM tiles WHERE variation = :variation");
      $query->bindValue(":variation", $this->id);
      $query->execute();

      return $query->rowCount(); // the number of rows returned from this query
   }

   public function getTileIds() {
      $query = $this->con->prepare("SELECT id FROM tiles WHERE variation = :variation
                                    ORDER BY RAND(), playOrder ASC LIMIT 7");
      $query->bindValue(":variation", $this->id);
      $query->execute();

      $array = array();

      while($row = $query->fetch(PDO::FETCH_ASSOC)) {
         array_push($array, $row["id"]);
      }

      return $array;
   }

}
?>