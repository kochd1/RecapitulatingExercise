<!DOCTYPE html>
<html>

<!-- head of this website-->
<head>
  <link href="style2.css" type="text/css" rel="stylesheet">
  <title>Patient Vital Signs</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<!-- body of this website-->
<body>

  <div class="header">
    <h1>Hospital Group-I</h1>
    <p>Care for life</p>
  </div>

  <div class="navbar">
    <a href="patientList.php">Home</a>
    <a href="logout.php" class="right">Logout</a>
  </div>


  <div class="side">
    <div class="alert alert-info">
      <?php
        session_start();
        // First, we test if user is logged. If not, goto index.php (login page).
        if(!isset($_SESSION['user'])){
        header("Location: index.php");
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
                echo "<h2> Patient: ".$line['first_name']."  ".$line['name']."</h2>";
                echo "<h5>Select a Sign:</h5>";
              }
             } else{
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

      <div class="btn-group" style="width:100%">
        <button class="btn-primary" onclick="displayVitalSigns('temperature');">Temperature</button>
        <button class="btn-primary" onclick="displayVitalSigns('pulse');">Pulse</button>
        <button class="btn-primary" onclick="displayVitalSigns('activity');">Activity</button>
        <button class="btn-primary" onclick="displayVitalSigns('bloodpressure');">Blood Pressure</button>
        <h2>Medicine List</h2>
        <button class="btn-primary" onclick="displayMedicicine('medicine');">Medicine</button>
      </div>

      <h3>Settings</h3>
      <p>Add a Medicine</p>
      <button class="btn-primary" onclick="displayNewMedicinePopup('newMed');">Add New Medicine</button>
  </div>


  <div class="main">
    <h2>Vital Signs and Medicines</h2>

    <?php
                if ($patientID > 0) {
                $sql = "SELECT sign.signID, sign_name, value, time, note
                        FROM patient, vital_sign, sign
                        WHERE patient.patientID = vital_sign.patientID
                        AND vital_sign.signID = sign.signID
                        AND patient.patientID = :patientID";

              if(isset($_GET['id'])) {
                $patientID = (int)($_GET['id']);
              }
          
              $statement = $dbh->prepare($sql);
              $statement->bindParam(':patientID', $patientID, PDO::PARAM_INT);
              $result = $statement->execute();
              
              $i = 0;
              while($line = $statement->fetch()) {
                  if($i == 0){
                    echo "<table id='".strtolower($line['sign_name'])."' class='signs'>";
                    echo "<tr>";
                    echo "<th>"."Sign Name"."</th>";
                    echo "<th>"."Value"."</th>";
                    echo "<th>"."Time"."</th>";
                    echo "<th>"."Note"."</th>";  
                    echo "</tr>";
                    $i++;
                  } else if ($line['signID'] > $i){
                    echo "</table>";
                    echo "<table id='".strtolower($line['sign_name'])."' class='signs'>";
                    $i++;
                    echo "<tr>";
                    echo "<th>"."Sign Name"."</th>";
                    echo "<th>"."Value"."</th>";
                    echo "<th>"."Time"."</th>";
                    echo "<th>"."Note"."</th>";  
                    echo "</tr>";
                  }
                  echo "<tr>";
                  echo "<td>".$line['sign_name']."</td>";
                  echo "<td>".$line['value']."</td>";
                  echo "<td>".$line['time']."</td>";
                  echo "<td>".$line['note']."</td>";  
                  echo "</tr>";
               }
              echo '</table>';
              echo '<div id="warning" class="signs">No List exists</div>';
              }
              else{
                echo "<h1>The patient does not exist</h1>";
              }
      
          ?>

      <?php
                if ($patientID > 0) {
                $sql2 = "SELECT m.medicineID, m.medicamentID, m.time, m.quantity, me.medicament_name, m.note
                                FROM medicine m, medicament me
                                WHERE m.medicineID = me.medicamentID
                                AND m.medicineID = :patientID";  
                                
                 if(isset($_GET['id'])) {
                 $patientID = (int)($_GET['id']);
                 }
                 
              $statement2 = $dbh->prepare($sql2);
              $statement2->bindParam(':patientID', $patientID, PDO::PARAM_INT);
              $result2 = $statement2->execute();
              
              $i = 0;  
              while($line2 = $statement2->fetch()) {
                if($i == 0){
                  echo "<table id='"."medicine"."' class='medis'>";
                  $i++;
                  echo "<tr>";
                  echo "<th>"."Medicine ID"."</th>";
                  echo "<th>"."Time"."</th>";
                  echo "<th>"."Quantity"."</th>";
                  echo "<th>"."Meicament Name"."</th>";  
                  echo "<th>"."Note"."</th>";  
                  echo "</tr>";
                } else if ($line2['medicineID'] > $i){
                  echo "</table>";
                  echo "<table id='"."medicine"."' class='medis'>";
                  $i++;
                  echo "<tr>";
                  echo "<th>"."Medicine ID"."</th>";
                  echo "<th>"."Time"."</th>";
                  echo "<th>"."Quantity"."</th>";
                  echo "<th>"."Meicament Name"."</th>";  
                  echo "<th>"."Note"."</th>";  
                  echo "</tr>";
                }
                  echo "<tr>";
                  echo "<td>".$line2['medicineID']."</td>";
                  echo "<td>".$line2['time']."</td>";
                  echo "<td>".$line2['quantity']."</td>";
                  echo "<td>".$line2['medicament_name']."</td>";
                  echo "<td>".$line2['note']."</td>";  
                  echo "</tr>";
               }
              echo '</table>';
              echo '<div id="warning2" class="medis">No List exists</div>';
              }
              else{
                echo "<h1>The patient does not exist</h1>";
              }
          
          ?>


        <div class="modalMedicine">
          <form action="patientVitalSigns.php" method="post">
            <input type="hidden" name="id" value="1">
            <table>
              <tr>
                <td>Medicament</td>
                <td>
                  <select name="medicamentID">
                    <option value="4">Adrenalin</option>
                    <option value="2">Aspirin 1000 mg</option>
                    <option value="1">Aspirin 500mg</option>
                    <option value="3">Morphin</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Quantity</td>
                <td>
                  <input type="text" name="quantity">
                </td>
              </tr>
              <tr>
                <td>Note</td>
                <td>
                  <textarea name="note"></textarea>
                </td>
              </tr>
              <tr>
                <td>Date/time</td>
                <td>
                  <input type="text" name="dateTime" placeholder="DD.MM.YYYY hh:mm:ss">
                </td>
              </tr>
              <tr>
                <td>Physician</td>
                <td>
                  <select name="physicianID">
                    <option value="2">Gregory House</option>
                    <option value="2">James Wilson</option>
                  </select>
                </td>
              </tr>
            </table>
            <input type="submit" name= "submit" value="Submit">
          </form>
        </div>

        <?php
          include('pdo.inc.php');

          if ($patientID > 0) {
            if(isset($_GET['id'])) {
              $patientID = (int)($_GET['id']);
            }
            if(isset($_POST['submit'])){
              $sql3 = "INSERT INTO medicine (patientID, time, quantity, medicineID, note)
              values(?, ?, ?, ?)";
              $stmt = $conn->prepare($sql3);
              $stmt-> bind_param(':patientID', $patientID, $dateTime, $quantity, $medID, $note, PDO::PARAM_INT);

          $medID = $_POST['medicineID'];
          $quantity = $_POST['quantity'];
          $note = $_POST['note'];
          $dateTime = $_POST['timeAndDate'];
          
          $stmt-> execute();

          echo "<meta http-equiv='refresh' content='0'>";
           
          $stmt->close();
          $conn->close();
            }
          }
        
          ?>
  </div>


  <script>
    function displayVitalSigns(sign) {
      var list = document.getElementsByClassName("signs");
      for (var i = 0; i < list.length; i++) {
        list[i].style.display = "none";
      }
      try {
        document.getElementById(sign).style.display = "table";
      } catch (err) {
        document.getElementById('warning').style.display = "block";
      }

    }

    function displayMedicicine(medi) {
      var list = document.getElementsByClassName("medis");
      for (var i = 0; i < list.length; i++) {
        list[i].style.display = "none";
      }
      try {
        document.getElementById(medi).style.display = "table";
      } catch (err) {
        document.getElementById('warning2').style.display = "block";
      }
    }
      function displayNewMedicinePopup(newMe) {
        // var popup = document.getElementById("addValue");
        // popup.classList.toggle("show");
        var list = document.getElementsByClassName("modalMedicine");
      for (var i = 0; i < list.length; i++) {
        list[i].style.display = "none";
      }
      try {        
        console.log(document.getElementById(newMe));
        
        document.getElementById(newMe).style.display = "table";
      } catch (err) {
        document.getElementById('warning2').style.display = "block";
      }
      }

      //   var modal = document.getElementById('modalMedicine');
      //   modal.style.display = "none";

      //   var addBtn = document.getElementById("addValue");
      //   addBtn.onclick = function () {
      //     modal.style.display = "block";
      //   }

      //   window.onclick = function (event) {
      //     if (event.target == modal) {
      //       modal.style.display = "none";
      //     }
      //   }
      // }
  </script>

</body>
</html>