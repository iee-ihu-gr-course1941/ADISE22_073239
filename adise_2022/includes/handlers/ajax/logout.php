<?php 
session_start(); 
/* needed to let our site know we're using sessions. without session_start() we can't
destroy the session */ 
session_destroy(); /* how we logout, stop the session, session is how we keep track
whether they are logged in or not */
?>