
<link href="style.css" type="text/css" rel="stylesheet">

<?php
session_start();

unset($_SESSION['user']);

header('refresh: 3; url=index.php');



?>

<style>
h2{font-size: 40px; margin-top: 30px;}
a{font-size: 30px;}

</style>

<center> 
    <h2>You've been successfully logged out!</h2>
    <a href="index.php">Back to login page</a>
</center>


