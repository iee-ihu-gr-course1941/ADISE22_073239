<?php 
class Board {

   private $con, $id, $name, $owner;

   public function __construct($con, $data) {
      // data from the table. Either pass an id or mySQL data into it.
      if(!is_array($data)) { // if the data that was passed in is not an array,
         // that means they've passed in an id
         $query = $con->prepare("SELECT * FROM boards WHERE id = :id");
         $query->bindValue(":id", $data);
         $query->execute();

         $data = $query->fetch(PDO::FETCH_ASSOC);
      }

      /* If it gets here we know that data is an array.
      If at first $data is an id we convert it into an array that contains the results.
      If already is an array we know it already has mySQL results */
      $this->con = $con;
      $this->id = $data["id"];
      $this->name = $data["name"];
      $this->owner = $data["owner"];
   }

   public function getId() {
      return $this->id;
   }

   public function getName() {
      return $this->name;
   }

   public function getOwner() {
      return $this->owner;
   }

   public function getNumberOfTiles() {
      $query = $this->con->prepare("SELECT tileId FROM boardtiles 
                                    WHERE boardId = :boardId");
      $query->bindValue(":boardId", $this->id);
      $query->execute();

      return $query->rowCount();
   }

   public function getTileIds() {
      $query = $this->con->prepare("SELECT tileId FROM boardtiles 
                                    WHERE boardId = :boardId ORDER BY boardOrder ASC");
      $query->bindValue(":boardId", $this->id);
      $query->execute();

      $array = array();

      while($row = $query->fetch(PDO::FETCH_ASSOC)) {
         array_push($array, $row["tileId"]);
      }

      // will return all the tileId's for this board
      return $array;
   }

   public static function getBoardgameDropdown($con, $username) {
      $dropdown = "<select class='item board'>
                     <option value=''>Add to Board</option>";

      $query = $con->prepare("SELECT id, name FROM boards WHERE owner = :owner");
      $query->bindValue(":owner", $username);
      $query->execute();
      while($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $id = $row["id"];
         $name = $row["name"];

         $dropdown = $dropdown . "<option value='$id'>$name</option>";
      }
      return $dropdown . "</select>";
   }
}
?>