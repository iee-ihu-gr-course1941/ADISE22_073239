<?php 
require_once("../../config.php");

// one query which inserts the data into the database
// make sure the parameters are set
// the two string have to match with how we named them in our ajax call. 
// We have to match whatever we called them in the script.js file
if(isset($_POST["name"]) && isset($_POST["username"])) {

   $name = $_POST["name"];
   $username = $_POST["username"];
   $date = date("Y-m-d");

   $query = $con->prepare("INSERT INTO boards (name, owner, dateCreated)
                           VALUES(:name, :owner, :dateCreated)");
   $query->bindValue(":name", $name);
   $query->bindValue(":owner", $username);
   $query->bindValue(":dateCreated", $date);

   $query->execute();
}
else {
   echo "Name or username parameters not passed into file."; 
}
?>