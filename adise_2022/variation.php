<?php 
require_once("includes/includedFiles.php");

if(isset($_GET["id"])) {
   $variationId = $_GET["id"];
}
else {
   header("Location: index.php");
}

$variation = new Variation($con, $variationId);
$player = $variation->getPlayer();
$playerId = $player->getId();
?>

<div class="entityInfo">

   <div class="leftSection">
      <img src="<?php echo $variation->getArtworkPath(); ?>">
   </div>

   <div class="rightSection">
      <h2><?php echo $variation->getTitle(); ?></h2>
      <p role="link" tabindex="0" 
         onclick="openPage('player.php?id=$playerId')">Player  
            <?php echo $player->getName(); ?></p>
      <p>Played with <?php echo $variation->getNumberOfTiles(); ?> number of tiles.</p>
   </div>

</div>

<div id="playingBoardContainer">

   <div class="tilelistContainerLeft">
      <ul class="tilelist borderRight">

         <?php 
            $tileIdArrayLeft = $variation->getTileIds();

            $i = 1;
            foreach($tileIdArrayLeft as $tileId) {

               $variationTile = new Tile($con, $tileId);
               $variationTile->incrementPlays();

               echo "<li class='tilelistRow'>
                        <div class='tileCount'>
                           <img class='play' src='assets/images/icons/play-white.png'>
                           <span class='tileNumber'>$i</span>
                        </div>

                        <div class='tileInfo'>
                           <img class='tileImage' src='" . $variationTile->getPath() . "'>
                        </div>

                        <div class='tileOptions'>
                           <input type='hidden' class='tileId' 
                                    value='" . $variationTile->getId() . "'>
                           <img class='optionsButton' src='assets/images/icons/more.png'
                                          onclick='showOptionsMenu(this)'>
                        </div>

                        <div class='tilePoints'>
                           <span class='points'>" . $variationTile->getPoints() . "</span>
                        </div>
                     </li>";

               $i++;

               $variationTile->updatePlayedTiles($variationId);
            }
         ?>

         <script>
            var tempTileIdsLeft = '<?php echo json_encode($tileIdArrayLeft); ?>';
            tempPlaylistLeft = JSON.parse(tempTileIdsLeft);
            /* contains the tiles of the page at the moment. 
            We've converted our PHP array into JSON format. Then we've used
            the JSON format and converted it into an object that we can access. */
         </script>

      </ul>
   </div>

   <div class="playingBoardCenter">

   </div>

   <div class="tilelistContainerRight">
      <ul class="tilelist borderLeft">

         <?php 
            $tileIdArrayRight = $variation->getTileIds();

            $i = 1;
            foreach($tileIdArrayRight as $tileId) {

               $variationTile = new Tile($con, $tileId);
               $variationTile->incrementPlays();
               $hasPlayed = $variationTile->hasPlayed() ? "<i class='fa-solid fa-circle-check seen'></i>" : "";

               echo "<li class='tilelistRow'>
                        <div class='tileCount'>
                           <img class='play' src='assets/images/icons/play-white.png'>
                           <span class='tileNumber'>$i</span>
                        </div>

                        <div class='tileInfo'>
                           <img class='tileImage' src='" . $variationTile->getPath() . "'>
                        </div>

                        <div class='tileOptions'>
                           <input type='hidden' class='tileId' 
                                    value='" . $variationTile->getId() . "'>
                           <img class='optionsButton' src='assets/images/icons/more.png'
                                          onclick='showOptionsMenu(this)'>

                                 $hasPlayed
                        </div>

                        <div class='tilePoints'>
                           <span class='points'>" . $variationTile->getPoints() . "</span>
                        </div>
                     </li>";

               $i++;

               $variationTile->updatePlayedTiles($variationId);
            }
         ?>

         <script>
            var tempTileIdsRight = '<?php echo json_encode($tileIdArrayRight); ?>';
            tempPlaylistRight = JSON.parse(tempTileIdsRight);
            /* contains the tiles of the right player at the moment.
            We've converted our PHP array into JSON format and then we've used 
            the JSON format and converted it into an object that we can access. */
         </script>

      </ul>
   </div>

</div>

<nav class="optionsMenu">
   <input type="hidden" class="tileId">
   <?php echo Board::getBoardgameDropdown($con, $userLoggedIn->getUsername()); ?>
   <!-- returns the select element with the options inside -->
</nav>