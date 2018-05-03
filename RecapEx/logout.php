
<link href="style.css" type="text/css" rel="stylesheet">

<?php
session_start();

unset($_SESSION['user']);

?>
<center> 
    <h2>You've been successfully logged out!</h2>
    <a href="main.php">Back to login page</a>
</center>


