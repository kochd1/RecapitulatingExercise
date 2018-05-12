<link href="style.css" type="text/css" rel="stylesheet">

<?php
session_start();

unset($_SESSION['user']);

header('refresh: 3; url=index.php');

?>

<center> 

    <h2>You've been successfully logged out!</h2>
    <a href="index.php">Back to login page</a>

</center>





