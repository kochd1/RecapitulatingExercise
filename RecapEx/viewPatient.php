<html>
<head>
<link href="style.css" type="text/css" rel="stylesheet">
<div class="navbar">
  <a href="logout.php">Logout</a>
  <p>Patient vital signs</p>
</div>
</head>

<body>
<div> .. </div>

<table>
<tr>
    <th>Vital Sign</th>
    <th>Value</th>
    <th>Time</th>
    <th>Note</th>
</tr>

<?php
session_start();

// First, we test if user is logged. If not, goto main.php (login page).
if(!isset($_SESSION['user'])){
  header("Location: main.php");
  //echo "problem with user";
  exit();
}
include('pdo.inc.php');

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    
    $patientID=0;
    if(isset($_GET['id'])) {
      $patientID = (int)($_GET['id']);
    }

    if ($patientID > 0) {
      $sql0 = "SELECT name, first_name 
               FROM patient
               WHERE patient.patientID = :patientID";

    $statement0 = $dbh->prepare($sql0);
    $statement0->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $result0 = $statement0->execute();

    while($line = $statement0->fetch()){
      echo "<h1> Patient : ".$line['first_name']."  ".$line['name']."</h1>";
      echo "<br>\n";
    }

      /*** echo a message saying we have connected ***/
      $sql = "SELECT sign_name, value, time, note
              FROM patient, vital_sign, sign
              WHERE patient.patientID = vital_sign.patientID
              AND vital_sign.signID = sign.signID 
              AND patient.patientID = :patientID";

    $statement = $dbh->prepare($sql);
    $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $result = $statement->execute();

    // while($line = $statement->fetch()){
    //   echo $line['sign_name']." = ".$line['value']. " at ".$line['time'];

    //   echo "<br>\n";
    // }
    foreach ($statement as $row) {
      echo "<tr>
       <td> $row[sign_name].</td>
       <td> $row[value].</td>
       <td> $row[time].</td>
       <td> $row[note].</td>
     </tr>";
     }
    }
    else{
      echo "<h1>The patient does not exist</h1>";
    }

    //$dbh = null;
}
catch(PDOException $e)
{
    /*** echo the sql statement and error message ***/
    echo $e->getMessage();
}

?>

<h2> Exercise 2</h2>
<script>
  function displayVitalSigns(sign){
    var list = document.getElementsByClassName("signs");
    for(var i in list){
      if(list[i].style !== undefined){
	      list[i].style.display="none";
      }
    }
    var list2 = document.getElementsByClassName(sign);
    if(list2){
      for(var i2 in list2){
	      if(list2[i2].style !== undefined){
	      list2[i2].style.display="block";
	}
      }
    }
    else{
      alert('no list');
    }
  }
  </script>

<style>
.Temperature {
    display: none;
    }
.Pulse {
    display: none;
 }
  .Activity {
        display: none;
       }
  </style>

<div class="btn-group" style="width:100%">
  <button style="width:25%" onclick="displayVitalSigns('Temperature');">Temperature</button>
  <br>
  <button style="width:25%" onclick="displayVitalSigns('Pulse');">Pulse</button>
  <br>
  <button style="width:25%" onclick="displayVitalSigns('Activity');">Activity</button>
  <br>
  <button style="width:25%">Blood Pressure</button>
  <br>
  <button style="width:25%">Medication</button>
</div>

  <?php
  try {

      if($patientID >0){
      $sql = "SELECT sign_name, value, time, note
              FROM patient, vital_sign, sign
              WHERE patient.patientID = vital_sign.patientID
              AND vital_sign.signID = sign.signID 
              AND patient.patientID = :patientID";

    $statement = $dbh->prepare($sql);
    $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $result = $statement->execute();

    while($line = $statement->fetch()) {
      echo "<div class='signs ".$line['sign_name']."'>".$line['value']. " at ".$line['time']."</div>";
      }
    }
    else{
      echo "<h1>The patient does not exist</h1>";
    }

    $dbh = null;
}
catch(PDOException $e)
{

    /*** echo the sql statement and error message ***/
    echo $e->getMessage();
}

  ?> 

</table>
</body>
</html>
