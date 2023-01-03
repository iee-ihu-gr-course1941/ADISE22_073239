<?php 
require_once("includes/includedFiles.php");
?>

<div class="boardsContainer">

   <div class="gridViewContainer">
      <h2>BOARDS</h2>

      <div class="buttonItems">
         <button class="button red" onclick="createBoard()">NEW BOARD</button>
      </div>

      <!-- With the User class created we will start creating the query which will get the
            board for that user --> 
      <?php 
         $username = $userLoggedIn->getUsername();
         /* $userLoggedIn is the User object we created in includedFiles.php,
         $username should contain the username of the userLoggedIn */

         $boardQuery = $con->prepare("SELECT * FROM boards WHERE owner = :owner");
         $boardQuery->bindValue(":owner", $username);

         $boardQuery->execute();

         if($boardQuery->rowCount() == 0) {
            echo "<span class='noResults'>You don't have any boards yet.</span>";
         }

         // Each row returned from the $boardQuery
         while($row = $boardQuery->fetch(PDO::FETCH_ASSOC)) {

            // create a Board object, pass the con variable and the $row which contains
            // the data from the table
            $board = new Board($con, $row);

            echo "<div class='gridViewItem' role='link' tabindex='0'
                     onclick='openPage(\"board.php?id=" . $board->getId() . "\")'>
            
                     <div class='boardImage'>
                        <img src='assets/images/icons/board.png'>
                     </div>

                     <div class='gridViewInfo'>" 
                        . $board->getName() . 
                     "</div>

                  </div>";
         }
      ?>
      
   </div>

</div>