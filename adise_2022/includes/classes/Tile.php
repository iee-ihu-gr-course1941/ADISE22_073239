<?php 
class Tile {

   private $con, $id, $sqlData;

   public function __construct($con, $id) {
      $this->con = $con;
      $this->id = $id;

      $query = $this->con->prepare("SELECT * FROM tiles WHERE id = :id");
      $query->bindValue(":id", $this->id);
      $query->execute();

      $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
   }

   public function getTitle() {
      return $this->sqlData["title"];
   }

   public function getId() {
      return $this->sqlData["id"];
   }

   public function getPoints() {
      return $this->sqlData["points"];
   }

   public function getPath() {
      return $this->sqlData["filePath"];
   }

   public function getPlays() {
      return $this->sqlData["plays"];
   }

   public function getSqlData() {
      return $this->sqlData;
   }

   public function getPlayer() {
      return new Player($this->con, $this->sqlData["player"]);
   }

   public function getVariation() {
      return new Variation($this->con, $this->sqlData["variation"]);
   }

   public function incrementPlays() {
      $query = $this->con->prepare("UPDATE tiles SET plays = plays + 1 WHERE id = :id");
      $query->bindValue(":id", $this->getId());
      $query->execute();
   }

   public function updatePlayedTiles($variationId) {
      $query = $this->con->prepare("UPDATE tiles SET isPlayed = 1
                                    WHERE id = :currentTileId 
                                    AND variation = :variationId");
      $query->bindValue(":currentTileId", $this->getId());
      $query->bindValue(":variationId", $variationId);
      $query->execute();
   }

   public function hasPlayed() {
      $query = $this->con->prepare("SELECT * FROM boardprogress
                                    WHERE tileId = :tileId AND isPlayed = 1");
      $query->bindValue(":tileId", $this->getId());
      $query->execute();

      return $query->rowCount() != 0;
   }
}
?>