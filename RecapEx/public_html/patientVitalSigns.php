<!DOCTYPE html>
<html>
<head>
<link href="style2.css" type="text/css" rel="stylesheet">
<title>Patient Vital Signs</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div class="header">
  <h1>Spital Group-I</h1>
  <p>Care for life</p>
</div>

<div class="navbar">
  <a href="patientList.php">Home</a>
  <a href="logout.php" class="right">Logout</a>
</div>

<div class="row">
  <div class="side">
    <div class="alert alert-info">
        <?php
        session_start();
        // First, we test if user is logged. If not, goto main.php (login page).
        if(!isset($_SESSION['user'])){
        header("Location: main.php");
        exit();
        }
        include('pdo.inc.php');
        echo "<a> Welcome Dr. Marc ".$_SESSION['user']."</a>";
        ?>
      </div>

      <h2>Vital Signs List</h2>

            <?php
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
                echo "<h5>Select a Sign:</h5>";
                echo "<h2> Patient: ".$line['first_name']."  ".$line['name']."</h2>";
              }
          ?>
              <div class="btn-group" style="width:100%">
              <button class="btn-primary" onclick="displayVitalSigns('Temperature');">Temperature</button>
              <br>
              <button class="btn-primary" onclick="displayVitalSigns('Pulse');">Pulse</button>
              <br>
              <button class="btn-primary" onclick="displayVitalSigns('Activity');">Activity</button>
              <br>
              <button class="btn-primary">Blood Pressure</button>
              <br>
              <button class="btn-primary">Medication</button>
            </div>
      
      <h3>Settings</h3>
        <p>Add a Medication</p>
        <button class="btn-primary" id="addMedis"><i class="fas fa-user-plus"></i> Add New Medicament</button>
  </div>


  <div class="main">
      <h2>Vital signs</h2>
    <table>
        <tr>
          <th>Vital Sign</th>
          <th>Value</th>
          <th>Time</th>
          <th>Note</th>
        </tr>
      <?php
                /*** echo a message saying we have connected ***/
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
          
              //$dbh = null;
          }
          catch(PDOException $e)
          {
              /*** echo the sql statement and error message ***/
              echo $e->getMessage();
          }
          
          ?>
        </table>
  </div>
</div>

<div class="footer">
  <h2>Footer</h2>
</div>

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
</body>
</html>
