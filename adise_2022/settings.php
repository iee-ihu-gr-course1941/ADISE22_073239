<?php 
require_once("includes/includedFiles.php");
?>

<div class="entityInfo">

   <div class="centerSection">
      <div class="userInfo">
         <h1><?php echo $userLoggedIn->getFirstAndLastName(); ?></h1>
         <!-- in includedFiles.php we have a User object created to use -->
      </div>
   </div>

   <div class="buttonItems">
      <button class="button" onclick="openPage('updateDetails.php')">USER DETAILS</button>
      <button class="button" onclick="logout()">LOGOUT</button>
   </div>

</div>