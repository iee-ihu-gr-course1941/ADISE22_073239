<?php 
require_once("includes/includedFiles.php");

if(isset($_GET["term"])) {
   $term = urldecode($_GET["term"]);
}
else {
   $term = "";
}
?>

<div class="searchContainer">

   <h4>Search for a tile to add in the Board</h4>
   <input type="text" class="searchInput" value="<?php echo $term; ?>"
   placeholder="Start typing..." onfocus="this.value = this.value">
   <!-- this.value = this.value, when the input is focused it sets the value to be
   whatever value currently has -->
</div>

<script>

$(".searchInput").focus(); // will give the input field focus as soon as the page loads

   $(function() {

      $(".searchInput").keyup(function() { 
         // perform an event everytime the user types a letter
         clearTimeout(timer);

         timer = setTimeout(function() {
            var val = $(".searchInput").val(); // get the value of our input field
            openPage("search.php?term=" + val); // append to the string
         }, 2000);
      });

   });
/* execute something after a certain time. Reload the page 1 second after they finish
typing. Wait until they finish typing. When I type something it cancels the timer and
resets a new one. clearTimeout() means every time we type it starts the timer again.
When we finish typing the 1000 miliseconds will expire and then it will execute the code */
</script>

<?php if($term == "") exit(); ?>
<!-- if the search term is an empty string don't do anything else on this page, stop
loading. We put it here so that it still load the search bar. So, the input field will 
always be loaded because it won't quit loading until it gets to this point. -->

<div class="tilelistContainerLeft borderBottom">
   <h2>TILES</h2>
   <ul class="tilelist borderRight">

      <?php 
         $sql = "SELECT * FROM tiles WHERE title LIKE CONCAT('%', :term, '%') LIMIT 10";
         // CONCAT joins a string up
         $tilesQuery = $con->prepare($sql);
         
         $tilesQuery->bindValue(":term", $term);
         $tilesQuery->execute();

         if($tilesQuery->rowCount() == 0) {
            // if number of rows returned is 0
            echo "<span class='noResults'>No tiles found matching " . $term . "</span>";
         }

         $tileIdArray = array(); 

         $i = 1;
         while($row = $tilesQuery->fetch(PDO::FETCH_ASSOC)) {
            // loop over all the rows returned by this query

            if($i > 15) {
               // show up to 15 results before we leave the loop
               break;
            }

            array_push($tileIdArray, $row["id"]); //the value we wanna push into the array

            $variationTile = new Tile($con, $row["id"]);

            echo "<li class='tilelistRow'>
                     <div class='tileCount'>
                        <img class='playSearch' src='assets/images/icons/play-white.png'>
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

<div class="gridViewContainer">
   <h2>VARIATIONS</h2>
   
   <?php 
      $sql = "SELECT * FROM variations WHERE title LIKE CONCAT('%', :term, '%') LIMIT 6";

      $variationQuery = $con->prepare($sql);

      $variationQuery->bindValue(":term", $term);
      $variationQuery->execute();

      if($variationQuery->rowCount() == 0) {
         echo "<span class='noResults'>No variations found matching " . $term . "</span>";
      }

      while($row = $variationQuery->fetch(PDO::FETCH_ASSOC)) {
         echo "<div class='gridViewItem'>
                  <span role='link' tabindex='0' 
                     onclick='openPage(\"variation.php?id=" . $row["id"] . "\")'>

                     <img src='" . $row["gamePath"] . "'>

                     <div class='gridViewInfo'>" . $row["title"] . "</div>
                  </span>
               </div>";
      }
   ?>

</div>

<nav class="optionsMenu">
   <input type="hidden" class="tileId">
   <?php echo Board::getBoardgameDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>