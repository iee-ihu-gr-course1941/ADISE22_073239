var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var currentIndex = 0;
var userLoggedIn;
var timer;

$(document).click(function(click) {
   var target = $(click.target); // what we clicked on

   if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
      // if what we clicked on doesn't have the class "item" and the class "optionsButton"
      hideOptionsMenu();
   }
});

$(window).scroll(function() {
   // window scroll event and execute the function to hide the options menu
   hideOptionsMenu();
});

// select the items with the class board. When that select is changed, then do the
// following code. Will be fired every single time that dropdown changes
$(document).on("change", "select.board", function() {
   var select = $(this); //JQuery object, reference to the select element 
   var boardId = select.val(); 
   /* this refers to the element which this event was fired on.
   this contains the option of the item that was selected and then we're taking the
   value which will contain the id of the board. Every time this select is changed
   this $boardId will contain the board that was selected */

   var tileId = select.prev(".tileId").val(); 
   // prev() goes up the DOM to find the input with the class of .tileId, 
   // prev takes the immediate ancestor

   // post ajax call, the php file, second parameter the data to pass in
   $.post("includes/handlers/ajax/addToBoard.php", { boardId: boardId, tileId: tileId })
   .done(function(error) { // the code we wanna execute

      if(error != "") {
         alert(error);
         return;
      }

      hideOptionsMenu(); // close the options menu after inserting the data
      select.val(""); // set the boardId to an empty value 
   });
});

function openPage(url) {
   // when we open a new page if the timer is not null, it has a value
   // clear the timer so it stops searching in the background
   if(timer != null) {
      clearTimeout(timer);
   }

   if(url.indexOf("?") == -1) {
      // if the URL doesn't have a question mark, indexOf looks to find
      // this character. If it does find it, it gives the position of it,
      // if not, it returns -1
      url = url + "?";
   }

   var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
   $("#mainContent").load(encodedUrl);
   $("body").scrollTop(0); // when we change page will automatically scroll to the top
   history.pushState(null, null, url); // puts the URL into the address bar
}

function showOptionsMenu(button) {
   // button is the three dots image
   var tileId = $(button).prevAll(".tileId").val();
   /* find the ancestor with the class .tileId , prevAll() will go up multiple levels
   tileId now contains the tile id because we're taking the value of the hidden input 
   inside the class tileOptions */
   var menu = $(".optionsMenu"); // retrieve the optionsMenu nav element
   var menuWidth = menu.width(); // width of the actual optionsMenu itself
   menu.find(".tileId").val(tileId);
   /* take the optionsMenu that appears and then go and find the .tileId item which is
   the input inside the .optionsMenu nav, and set its value to be the tileId.
   Every time the .optionsMenu is shown it's gonna take the tileId and then put that 
   into the .optionsMenu, so when we change a board we can go and get that tileId */

   var scrollTop = $(window).scrollTop(); // distance from top of window to top of documen
   var elementOffset = $(button).offset().top; // JQuery object of the parameter element 
   // Distance from top of document

   var top = elementOffset - scrollTop;
   var left = $(button).position().left; // how far from the left this button is

   // add these values to the menu css
   menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline" });
}

function hideOptionsMenu() {
   var menu = $(".optionsMenu");
   if(menu.css("display") != "none") {
      // if the optionsMenu is showing
      menu.css("display", "none");
   }
}

function createBoard() {
   console.log(userLoggedIn);
   var popup = prompt("Please enter the name of your board");

   if(popup != null) {

      $.post("includes/handlers/ajax/createBoard.php", { name: popup, username: userLoggedIn }).done(function(error) {

         if(error != "") {
            alert(error);
            return;
         }

         // do something when ajax returns
         openPage("yourBoard.php");
         // when we create the board it will just open yourBoard.php page
         // is just a page refresh
      });

   }
}

function deleteBoard(boardId) {
   var prompt = confirm("Are you sure you want to delete this board?");

   if(prompt) {

      $.post("includes/handlers/ajax/deleteBoard.php", { boardId: boardId })
      .done(function(error) {

         if(error != "") {
            alert(error);
            return;
         }

         // do something when ajax returns
         openPage("yourBoard.php"); // just go back to yourBoard page
      });
   }
}

function removeFromBoard(button, boardId) {
   var tileId = $(button).prevAll(".tileId").val();

   $.post("includes/handlers/ajax/removeFromBoard.php", { boardId: boardId, 
      tileId: tileId }).done(function(error) {

         if(error != "") {
            alert(error);
            return;
         }

         // do something when ajax returns
         openPage("board.php?id=" + boardId);
      });
}

/* emailClass is gonna be the class we use for our input. We get the input value
We get the input value and to do that we gonna pass the class through to our function
and we will use the class to create a JQuery selector to get the value */
function updateEmail(emailClass) {
   var emailValue = $("." + emailClass).val(); // append a dot and then add the parameter

   // ajax call, userLoggedIn is in the header.php the variable we echo inside the
   // <script> tags
   $.post("includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn }).done(function(response) {
      // update the span with the class .message
      $("." + emailClass).nextAll(".message").text(response);
      // wherever the email input is, go and get the next item with the class .message
      // which is the span and set the text to response
      // nextAll() gets the siblings elements on the same level
   });
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
   var oldPassword = $("." + oldPasswordClass).val();
   var newPassword1 = $("." + newPasswordClass1).val();
   var newPassword2 = $("." + newPasswordClass2).val();

   $.post("includes/handlers/ajax/updatePassword.php", 
         { // send all of these through to the updatePassword.php
            oldPassword: oldPassword,
            newPassword1: newPassword1,
            newPassword2: newPassword2,
            username: userLoggedIn
         }).done(function(response) {
               $("." + oldPasswordClass).nextAll(".message").text(response);
               // will update the span with the class .message 
         });
}

function logout() {
   // ajax call
   $.post("includes/handlers/ajax/logout.php", function() {
      location.reload();
      /* when return from the ajax call reload and then redirect we have in header.php
      which checks whether they're logged in or not, its gonna see we're not logged in
      anymore because we've just destroyed the session, so redirect them to the 
      register page */
   });
}