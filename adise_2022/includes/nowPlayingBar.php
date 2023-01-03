<?php 
   require_once("includes/classes/Tile.php");

   $tileQuery = $con->prepare("SELECT id FROM tiles ORDER BY RAND() LIMIT 14");
   $tileQuery->execute();

   $resultArray = array();

   while($row = $tileQuery->fetch(PDO::FETCH_ASSOC)) {
      array_push($resultArray, $row["id"]);
   }

   $jsonArray = json_encode($resultArray);
?>

<script>

$(document).ready(function() {
   var newPlaylist = <?php echo $jsonArray; ?>;
      setTile(newPlaylist[0], newPlaylist, false);
});

function setTile(tileId, newPlaylist, play) {

   $.post("includes/handlers/ajax/getTileJson.php", { tileId: tileId }, 
   function(data) {

      var tile = JSON.parse(data);

      $(".tileName span").text(tile.title);
      $(".tilePoints span").text("Points: "  + tile.points);
      $(".content .tileImage img").attr("src", tile.filePath);
   });

}


</script>

<div id="nowPlayingBarContainer">

   <div id="nowPlayingBar">

      <div id="nowPlayingLeft">

         <div class="content">
            
            <div class="tileImage">
               <img src="" class="tileArtwork">
            </div>

            <div class="tileInfo">

               <span class="tileName">
                  <span></span>
               </span>

               <span class="tilePoints">
                  <span></span>
               </span>

            </div>

         </div>

      </div>

      <div id="nowPlayingCenter">

         <div class="tileListContainer">

         

         </div>

      </div>

   </div>

</div>