<?php 
require_once("includes/includedFiles.php");
?>

<h1 class="pageHeadingBig">Dominoes Game</h1>

<div class="gridViewContainer">

   <?php 
         $gameQuery = $con->prepare("SELECT * FROM variations 
                                    ORDER BY RAND() LIMIT 6");
         $gameQuery->execute();

         while($row = $gameQuery->fetch(PDO::FETCH_ASSOC)) {

            echo "<div class='gridViewItem'>
                     <span role='link' tabindex='0' 
                        onclick='openPage(\"variation.php?id=" . $row['id'] . "\")'>
                         <img src='" . $row['gamePath'] . "'>

                        <div class='gridViewInfo'>"
                              . $row['title'] .       
                        "</div>
            
                  </div>";

         }
      ?>

</div>

   