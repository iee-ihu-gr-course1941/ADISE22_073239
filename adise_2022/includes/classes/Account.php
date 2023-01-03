<?php 
class Account {

   private $con;
   private $errorArray;

   public function __construct($con) {
      $this->con = $con;
      $this->errorArray = array();
   }

   public function login($un, $pw) {
      $pw = hash("sha512", $pw);

      $query = $this->con->prepare("SELECT * FROM users WHERE username = :un
                                    AND password = :pw");
      $query->bindValue(":un", $un);
      $query->bindValue(":pw", $pw);
      
      $query->execute();

      if($query->rowCount() == 1) {
         return true; // successful login
      }

      array_push($this->errorArray, Constants::$loginFailed);
      return false;
   }

   public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) {
      $this->validateFirstName($fn);
      $this->validateLastName($ln);
      $this->validateUsername($un);
      $this->validateEmails($em, $em2);
      $this->validatePasswords($pw, $pw2);

      if(empty($this->errorArray)) {
         return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
      }

      return false;
   }

   private function insertUserDetails($fn, $ln, $un, $em, $pw) {

      $pw = hash("sha512", $pw);

      $query = $this->con->prepare("INSERT INTO users (firstName, lastName, username, 
                                    email, password) VALUES (:fn, :ln, :un, :em, :pw)");
      $query->bindValue(":fn", $fn);
      $query->bindValue(":ln", $ln);
      $query->bindValue(":un", $un);
      $query->bindValue(":em", $em);
      $query->bindValue(":pw", $pw);

      /*in PHP a mySQL query execution will return true or false based on whether it
      worked, so if the above query executes successfully and inserts the users detals
      it will return true. If there is a problem it will return false */
      return $query->execute();
   }

   private function validateFirstName($fn) {
      if(strlen($fn) < 2 || strlen($fn) > 25) {
         array_push($this->errorArray, Constants::$firstNameCharacters);
      }
   }

   private function validateLastName($ln) {
      if(strlen($ln) < 2 || strlen($ln) > 25) {
         array_push($this->errorArray, Constants::$lastNameCharacters);
      }
   }

   private function validateUsername($un) {
      if(strlen($un) < 2 || strlen($un) > 25) {
         array_push($this->errorArray, Constants::$usernameCharacters);
         return;
      }

      $query = $this->con->prepare("SELECT * FROM users WHERE username = :un");
      $query->bindValue(":un", $un);

      $query->execute();

      if($query->rowCount() != 0) {
         //means the username has been used by somebody else
         array_push($this->errorArray, Constants::$usernameTaken);
      }
   }

   private function validateEmails($em, $em2) {
      if($em != $em2) {
         array_push($this->errorArray, Constants::$emailsDontMatch);
         return;
      }

      if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
         array_push($this->errorArray, Constants::$emailInvalid);
         return;
      }

      $query = $this->con->prepare("SELECT * FROM users WHERE email = :em");
      $query->bindValue(":em", $em);
      $query->execute();

      if($query->rowCount() != 0) {
         array_push($this->errorArray, Constants::$emailTaken);
      }
   }

   private function validatePasswords($pw, $pw2) {
      if($pw != $pw2) {
         array_push($this->errorArray, Constants::$passwordsDoNotMatch);
         return;
      }

      if(preg_match('/[^A-Za-z0-9]/', $pw)) {
         array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
         return;
      }

      if(strlen($pw) > 30 || strlen($pw) < 5) {
         array_push($this->errorArray, Constants::$passwordCharacters);
         return;
      }
   }

   public function getError($error) {
      if(!in_array($error, $this->errorArray)) {
         $error = "";
      }
      return "<span class='errorMessage'>$error</span>";
   }
}
?>