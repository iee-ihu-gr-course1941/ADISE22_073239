<?php 
require_once("../../config.php");

if(isset($_POST["boardId"]) && isset($_POST["tileId"])) {
   $boardId = $_POST["boardId"];
   $tileId = $_POST["tileId"];

   $orderIdQuery = $con->prepare("SELECT MAX(boardOrder) + 1 as boardOrder 
                                 FROM boardtiles WHERE boardId = :boardId");
   $orderIdQuery->bindValue(":boardId", $boardId);
   $orderIdQuery->execute();
   
   // to get that value
   $row = $orderIdQuery->fetch(PDO::FETCH_ASSOC);
   $order = $row["boardOrder"];

   // query which it's gonna insert into the boardtiles
   $query = $con->prepare("INSERT INTO boardtiles (tileId, boardId, boardOrder)
                           VALUES (:tileId, :boardId, :boardOrder)");
   $query->bindValue(":tileId", $tileId);
   $query->bindValue(":boardId", $boardId);
   $query->bindValue(":boardOrder", $order);
   $query->execute();
}
else {
   echo "BoardId or tileId was not passed into addToBoard.php";
}
?>