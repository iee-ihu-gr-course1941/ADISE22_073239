<?php 
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

$account = new Account($con);

require_once("includes/handlers/login-handler.php");
require_once("includes/handlers/register-handler.php");

function getInputValue($name) {
   if(isset($_POST[$name])) {
      echo $_POST[$name];
   }
}

?>
<!DOCTYPE html>
<html>
   <head>
      <title>Dominoes Project</title>
      <link rel="stylesheet" type="text/css" href="assets/style/register.css">
      <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
      <script src="assets/js/register.js"></script>
   </head>
<body>
<?php 
   if(isset($_POST["registerButton"])) {
      echo '<script>
               $(document).ready(function() {
                  $("#loginForm").hide();
                  $("#registerForm").show();
               });
            </script>';
   }
   else {
      echo '<script>
               $(document).ready(function() {
                  $("#loginForm").show();
                  $("#registerForm").hide();
               });
            </script>';
   }
?>

<div id="background">

   <div id="loginContainer">

      <div id="inputContainer">
         <form id="loginForm" action="register.php" method="POST">
            <h2>Login to your account</h2>
            <p>
               <?php echo $account->getError(Constants::$loginFailed); ?>
               <label for="loginUsername">Username</label>
               <input id="loginUsername" name="loginUsername" type="text"
               placeholder="e.g. iChatzia" 
               value="<?php getInputValue('loginUsername') ?>" required>
            </p>
            <p>
               <label for="loginPassword">Password</label>
               <input id="loginPassword" name="loginPassword" type="password"
               placeholder="Your password" required>
            </p>

            <button type="submit" name="loginButton">LOG IN</button>

            <div class="hasAccountText">
               <span id="hideLogin">Don't have an account yet? Signup here.</span>
            </div>
         </form>

         <form id="registerForm" action="register.php" method="POST">
            <h2>Create your account</h2>
            <p>
               <?php echo $account->getError(Constants::$usernameCharacters); ?>
               <?php echo $account->getError(Constants::$usernameTaken); ?>
               <label for="username">Username</label>
               <input id="username" name="username" type="text" 
               placeholder="e.g. iChatzia" 
               value="<?php getInputValue('username') ?>" required>
            </p>

            <p>
               <?php echo $account->getError(Constants::$firstNameCharacters); ?>
               <label for="firstName">First name</label>
               <input id="firstName" name="firstName" type="text"
               placeholder="e.g. Giannis" 
               value="<?php getInputValue('firstName') ?>" required>
            </p>

            <p>
               <?php echo $account->getError(Constants::$lastNameCharacters); ?>
               <label for="lastName">Last name</label>
               <input id="lastName" name="lastName" type="text"
               placeholder="e.g. Chatzia" 
               value="<?php getInputValue('lastName') ?>" required>
            </p>

            <p>
               <?php echo $account->getError(Constants::$emailInvalid); ?>
               <?php echo $account->getError(Constants::$emailsDontMatch); ?>
               <?php echo $account->getError(Constants::$emailTaken); ?>
               <label for="email">Email</label>
               <input id="email" name="email" type="email" 
               placeholder="userExample@gmail.com" 
               value="<?php getInputValue('email') ?>" required>
            </p>

            <p>
               <label for="email">Confirm email</label>
               <input id="email2" name="email2" type="email"
               placeholder="userExample@gmail.com" 
               value="<?php getInputValue('email2') ?>" required>
            </p>

            <p>
               <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
               <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
               <?php echo $account->getError(Constants::$passwordCharacters); ?>
               <label for="password">Password</label>
               <input id="password" name="password" type="password" 
               placeholder="Your password" required>
            </p>

            <p>
               <label for="password2">Confirm password</label>
               <input id="password2" name="password2" type="password"
               placeholder="Confirm password" required>
            </p>

            <button type="submit" name="registerButton">SIGN UP</button>

            <div class="hasAccountText">
               <span id="hideRegister">Already have an account? Log in here.</span>
            </div>
         </form>
      </div>

      <div id="loginText">
         <h1>Play the Dominoes board game</h1>
         <h2>Log in with your own account and play the game</h2>
         <ul>
            <li>Place the tiles with two players</li>
            <li>Search for any tiles</li>
            <li>Create your own board</li>
            <li>Make multiple boards</li>
         </ul>
      </div>

   </div>

</div>
</body>
</html>