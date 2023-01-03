<?php 
if(isset($_POST["loginButton"])) {
   // login button was pressed
   $username = $_POST["loginUsername"];
   $password = $_POST["loginPassword"];

   $result = $account->login($username, $password);

   if($result) {
      // if login function returns true
      $_SESSION["userLoggedIn"] = $username;
      header("Location: index.php");
   }
}
?>