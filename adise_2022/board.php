<?php 
require_once("includes/includedFiles.php");

   if(isset($_GET["id"])) {
      $boardId = $_GET["id"];
   }
   else {
      header("Location: index.php");
   }

   $board = new Board($con, $boardId);
   $owner = new User($con, $board->getOwner());
?>

<div class="entityInfo">

   <div class="leftSection">
      <div class="boardImage">
         <img src="assets/images/icons/board.png">
      </div>
   </div>

   <div class="rightSection">
      <h2><?php echo $board->getName(); ?></h2>
      <p>Played by <?php echo $board->getOwner(); ?></p>
      <p><?php echo $board->getNumberOfTiles(); ?> tiles.</p>
      <button class="button" onclick="deleteBoard('<?php echo $boardId; ?>')">
      DELETE BOARD</button>
      <!-- the $boardId variable comes from the $_GET at the top PHP block. -->
   </div>

</div>

<div id="mainBoard">
   <ul class="tilesPlay">

      <?php 
         $tileIdArray = $board->getTileIds();

         $i = 1;
         foreach($tileIdArray as $tileId) {

            $boardTile = new Tile($con, $tileId);

            echo  "<li class='tileContainer'>
                     <div class='contents'>
                           <span class='pointsBoard'>$i</span>

                           <img class='imageBoard' src='" . $boardTile->getPath() . "'>
                        
                        <div class='tileInfoBoard'>
                           <div class='tileOptions'>
                              <input type='hidden' class='tileId' 
                                       value='" . $boardTile->getId() . "'>
                              <img class='optionsButton'
                              src='assets/images/icons/more.png'
                                             onclick='showOptionsMenu(this)'>
                           </div>
                           
                           <span>" . $boardTile->getPoints() . " points</span>
                        </div>
                     </div>
                  </li>";
                  
               $i++;
         }
      ?>

   </ul>

</div>

<nav class="optionsMenu">
   <input type="hidden" class="tileId">
   <?php echo Board::getBoardgameDropdown($con, $userLoggedIn->getUsername()); ?>
   <div class="item" onclick="removeFromBoard(this, '<?php echo $boardId; ?>')">
   Remove from Board</div>
</nav>