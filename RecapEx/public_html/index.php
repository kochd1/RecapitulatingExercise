<link href="style.css" type="text/css" rel="stylesheet">
<div class="container"><div class="item"></div><div>


<?php

session_start();
// Initialisation of passwords for the database
include('pdo.inc.php');

// Read the credentials if given as POST parameters
$user = '';
$pwd = '';
$message = '';

$logged = false;

if(isset($_SESSION['user'])){
  $logged = true;
  header("Location: patientList.php");
  exit();
}

if(!$logged){
  if(isset($_POST['user'])){
    $user = ($_POST['user']);

    }

  if(isset($_POST['pwd'])){
    $pwd = ($_POST['pwd']);
  }



  try {
    // Connect to the database
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

 
    // if the username is set, test if combination "username/password" is valid
    if($user !=''){
     
      // Initialise SQL query with place holders (:username and :password)
      $sql0 = "SELECT staff.staffID, staff.username, first_name, hashed_password
      FROM staff,credential
      WHERE staff.staffID = credential.staffID AND staff.username=:username AND hashed_password=sha(:password)";

      // parse the query and set the parameters for place holders.
      $statement0 = $dbh->prepare($sql0);
      $statement0->bindParam(':username', $user, PDO::PARAM_STR);
      $statement0->bindParam(':password', $pwd, PDO::PARAM_STR);

      // execute the query
      $result0 = $statement0->execute();

    
      // case if login was a success
      if($line = $statement0->fetch()){
          
	    echo "<h1> staff : ".$line['staffID']."  ".$line['username']." ".$line['hashed_password']."</h1>\n";
	    $logged=true;
	    $_SESSION['user']= $line['username'];
	    header("Location: patientList.php");
	    exit();
      }
      
      else{ // if login failed
	    $message= "Username and/or password faulty. Please try again!";
      }

      $dbh = null;
    }

  }

  catch(PDOException $e)
    {

      /*** echo the sql statement and error message ***/
      echo $e->getMessage();
    }
}

// the form is only displayed if the person is not logged.
if(!$logged){
?>

<style>

.container
{
     display: flex;
     align-items: center;
     justify-content: center;
     height: 50vh;
    
}
/*.item
{
     background-color: #f3f2ef;
     border-radius: 3px;
     width: 200px;
     height: 100px; 
}*/

h1{font-size: 85px; margin-bottom: 100px}

fieldset{background-color: white;
        border-color:#000000;
        margin-top: 50px;
        margin-left: 80px;
        width: 300px;}

</style>

<div>
  <h1>ePatient Data</h1>

    <form method='POST'>
      <fieldset>
<pre><span class="inner-pre" style="font-size: 20px;">
    <label for="Username">Username:</label>
    <input type="text" name="user" style= "width: 200px; height: 30px; font-size: 20px;">

    <label for="Password">Password:</label>
    <input type="password" name="pwd" style= "width: 200px; height:30px; font-size: 20px;">

   <input type="submit" value="Log in" style = "font-size: 20px; margin-left: 10px">
</span></pre>
</fieldset>
   </form>
   
</div>


   <?php
    echo "<p align = 'center'><b><font color = '#ff0000'>$message</font></b> </p>";

    }
  
  ?>