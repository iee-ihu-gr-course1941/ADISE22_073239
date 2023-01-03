<?php 
require_once("includes/config.php");
// session_start() code will be included on the
// index page and we can use sessions
require_once("includes/classes/User.php");
require_once("includes/classes/Player.php");
require_once("includes/classes/Variation.php");
require_once("includes/classes/Tile.php");
require_once("includes/classes/Board.php");

if(isset($_SESSION["userLoggedIn"])) {
   $userLoggedIn = new User($con, $_SESSION["userLoggedIn"]);
   $username = $userLoggedIn->getUserName();
   echo "<script>userLoggedIn = '$username';</script>";
}
else {
   header("Location: register.php");
}
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Dominoes Project</title>
      <link rel="stylesheet" type="text/css" href="assets/style/style.css">
      <script src="https://code.jquery.com/jquery-3.6.2.min.js"
      integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" 
      crossorigin="anonymous"></script>
      <script src="assets/js/script.js"></script>
      <!-- code that executes below this will have access 
            to the variables on this script -->
   </head>
<body>

   <div id="mainContainer">

      <div id="topContainer">

         <?php require_once("includes/navBarContainer.php"); ?>

         <div id="mainViewContainer">

            <div id="mainContent">


