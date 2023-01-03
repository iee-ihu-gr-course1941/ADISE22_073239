<?php 
require_once("../../config.php");

if(isset($_POST["boardId"])) {
   // $_POST because in our ajax call we're using $.post to send the data
   $boardId = $_POST["boardId"];

   // query that deletes the board
   $boardQuery = $con->prepare("DELETE FROM boards WHERE id = :boardId");
   $boardQuery->bindValue(":boardId", $boardId);
   $boardQuery->execute();

   // delete all the tiles that are in that board too. If you delete a board all the
   // references to those tiles in boardtiles table need to be deleted too.
   $tilesQuery = $con->prepare("DELETE FROM boardtiles WHERE boardId = :boardId");
   $tilesQuery->bindValue(":boardId", $boardId);
   $tilesQuery->execute();
}
else {
   echo "BoardId was not passed into deleteBoard.php";
}
?>