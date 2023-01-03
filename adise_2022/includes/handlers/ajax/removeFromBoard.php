<?php 
require_once("../../config.php");

if(isset($_POST["boardId"]) && isset($_POST["tileId"])) {
   // those two will have to match with what we've called them in our ajax call
   $boardId = $_POST["boardId"];
   $tileId = $_POST["tileId"];

   $query = $con->prepare("DELETE FROM boardtiles WHERE boardId = :boardId
                           AND tileId = :tileId");
   $query->bindValue(":boardId", $boardId);
   $query->bindValue(":tileId", $tileId);
   $query->execute();
}
else {
   echo "BoardId or tileId was not passed into removeFromBoard.php";
}
?>