<?php 

if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])) {
   // sent with ajax
   // every ajax request will contain this
   require_once("includes/config.php");
   require_once("includes/classes/User.php");
   //We're putting User class at the top because any of the classes 
   //below may want to use the User.php class and in order for them to use it has to already been declared
   require_once("includes/classes/Player.php");
   require_once("includes/classes/Variation.php");
   require_once("includes/classes/Tile.php");
   require_once("includes/classes/Board.php");

   if(isset($_GET["userLoggedIn"])) {
      $userLoggedIn = new User($con, $_GET["userLoggedIn"]);
   }
   else {
      echo "Username variable was not passed into page.";
      exit();
   }
}
else {
   // if it didn't come from an ajax request, they typed it manually
   require_once("includes/header.php");
   require_once("includes/footer.php");

   /* Call the function that opens the page. Will append the URL content
   We're in PHP so we have to echo this javaScript to execute */
   $url = $_SERVER["REQUEST_URI"];
   echo "<script>openPage('$url')</script>";
   exit();
}

?>