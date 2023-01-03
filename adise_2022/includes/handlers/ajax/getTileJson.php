<?php 
require_once("../../config.php");

if(isset($_POST["tileId"])) {
   $tileId = $_POST["tileId"];

   $query = $con->prepare("SELECT * FROM tiles WHERE id = :tileId");
   $query->bindValue(":tileId", $tileId);

   $query->execute();

   $resultArray = $query->fetch(PDO::FETCH_ASSOC);

   // echoing is how we return data from an ajax call
   // convert the array to JSON. JSON is how javaScript is gonna use our data
   echo json_encode($resultArray);
}
?>