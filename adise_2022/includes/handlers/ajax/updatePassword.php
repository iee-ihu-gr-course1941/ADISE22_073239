<?php 
require_once("../../config.php");

if(!isset($_POST["username"])) {
   echo "ERROR: Could not set username";
   exit();
}

if(!isset($_POST["oldPassword"]) || !isset($_POST["newPassword1"]) || 
      !isset($_POST["newPassword2"])) {
   // if oldPassword, newPassword1 or newPassword2 have not been set
   echo "Not all passwords have been set";
   exit();
}

if($_POST["oldPassword"] == "" || $_POST["newPassword1"] == "" || 
      $_POST["newPassword2"] == "") { // if any of them equals an empty string
         echo "Please fill in all fields";
         exit();
}

// If we get to this point we know that they've entered all the passwords so we can
// go and get the values
$username = $_POST["username"];
$oldPassword = $_POST["oldPassword"];
$newPassword1 = $_POST["newPassword1"];
$newPassword2 = $_POST["newPassword2"];
// all our values to PHP variables

// md5 the oldPassword because we gonna use the encrypted version when we check to see if
// it matches the current password. The passwords are stored in the users table encrypted
$oldMd5 = hash("sha512", $oldPassword);

// query to check if the password matches
$passwordCheck = $con->prepare("SELECT * FROM users WHERE username = :username
                                 AND password = :password");
$passwordCheck->bindValue(":username", $username);
$passwordCheck->bindValue(":password", $oldMd5);
$passwordCheck->execute();

if($passwordCheck->rowCount() != 1) {
   // if we didn't find 1 result
   echo "Password is incorrect";
   exit();
}
// If it doesn't do this part it will go to the code below

// If it gets there it means the password they entered for the oldPassword 
// is their oldPassword which is fine
if($newPassword1 != $newPassword2) {
   echo "Your new passwords do not match";
   exit();
}

if(preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
   // if it contains anything other than letters and numbers, we only need to check
   // $newPassword1 and not $newPassword2 because if we get at this point the passwords
   // are identical
   echo "Your password must only contain letters and/or numbers";
   exit(); 
}

if(strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
   echo "Your password must be between 5 and 30 characters";
   exit();
}

// At this point we know it was all fine
$newMd5 = hash("sha512", $newPassword1);

// Update the value in the table
$query = $con->prepare("UPDATE users SET password = :password
                        WHERE username = :username");
$query->bindValue(":password", $newMd5);
$query->bindValue(":username", $username);
$query->execute();

echo "Update successful";
?>