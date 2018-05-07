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
  <a href="patientList.php">Back to Home</a>
   <?php
        session_start();
        // First, we test if user is logged. If not, goto main.php (login page).
        if(!isset($_SESSION['user'])){
        header("Location: main.php");
        exit();
        }
        include('pdo.inc.php');
        echo "<a> User: ".$_SESSION['user']."</a>";
     ?>
  <a href="#">Einstellungen</a>
  <a href="logout.php" class="right">Logout</a>
</div>

<div class="row">
  <div class="side">
      <h2>Vital Signs1</h2>
      <h5>Select a Sign:</h5>
      <div table>
            <tr>
                <th>Vital Sign</th>
                <th>Value</th>
                <th>Time</th>
                <th>Note</th>
            </tr></div>
          
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
                echo "<h1> Patient : ".$line['first_name']."  ".$line['name']."</h1>";
                echo "<br>\n";
              }
          ?>
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
          
              // while($line = $statement->fetch()){
              //   echo $line['sign_name']." = ".$line['value']. " at ".$line['time'];
          
              //   echo "<br>\n";
              // }
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
          
      
      <h3>Settings</h3>
      <p>Add a Medication</p>
      <div class="fakeimg" style="height:60px;">Image</div><br>
      <div class="fakeimg" style="height:60px;">Image</div><br>
      <div class="fakeimg" style="height:60px;">Image</div>
  </div>
  <div class="main">
      <h2>Vital signs</h2>
      <h5>Title description, Dec 7, 2017</h5>
      <div class="fakeimg" style="height:200px;">Image</div>
      <p>Some text..</p>
      <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
      <br>
      <h2>TITLE HEADING</h2>
      <h5>Title description, Sep 2, 2017</h5>
      <div class="fakeimg" style="height:200px;">Image</div>
      <p>Some text..</p>
      <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
  </div>
</div>

<div class="footer">
  <h2>Footer</h2>
</div>

</table>  
</body>
</html>
