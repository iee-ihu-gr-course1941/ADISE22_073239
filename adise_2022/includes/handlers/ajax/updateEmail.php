<?php 
require_once("../../config.php");

if(!isset($_POST["username"])) {
   echo "ERROR: Could not set username";
   exit(); // prevent the rest of the page loading
}

if(isset($_POST["email"]) && $_POST["email"] != "") {

   $username = $_POST["username"];
   $email = $_POST["email"];

   if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // checks to see if the email is a valid format
      echo "Email is invalid";
      exit();
   }

   $emailCheck = $con->prepare("SELECT email FROM users WHERE email = :email
                                 AND username != :username");
   $emailCheck->bindValue(":email", $email);
   $emailCheck->bindValue(":username", $username);
   $emailCheck->execute();
   // username != :username, we're checking to see if it's already been used by another
   // user. We don't want to check if it's been used by the user who owns the email
   if($emailCheck->rowCount() > 0) {
      echo "Email is already in use";
      exit();
   }

   $updateQuery = $con->prepare("UPDATE users SET email = :email 
                                 WHERE username = :username");
   $updateQuery->bindValue(":email", $email);
   $updateQuery->bindValue(":username", $username);
   $updateQuery->execute();

   echo "Update successful";
}
else {
   echo "You must provide an email";
}
?>