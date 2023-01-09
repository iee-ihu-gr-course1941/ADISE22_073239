<?php 
ob_start();
session_start();
date_default_timezone_set("Europe/Athens");

try {
   $con = new PDO("mysql:dbname=adise;host=localhost", "it073239", "");

   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   /* static property on the PDO object called ATTR_ERRMODE. 
   Set the error reporting of this database to the ERRMODE_WARNING value */
}
catch(PDOException $e) {
   exit("Connection failed: " . $e->getMessage());
}
?>
