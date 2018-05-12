<!DOCTYPE html>
<html>

<!-- head of this website-->

<head>
  <link href="style2.css" type="text/css" rel="stylesheet">
  <title>Hospital Home</title>
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
    <a>Home</a>
    <a href="logout.php" class="right">Logout</a>
  </div>

  <div class="slide">
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

    <div style= "margin-left: 10px;">
    <h2>Patient list</h2>
    <h5>Select a Patient:</h5>

    <table>
      <tr>
        <th>Patient ID</th>
        <th>Name</th>
        <th>First Name</th>
        <th>Birthdate</th>
      </tr>

    </div>

      <?php
            try {
                $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
                /*** echo a message saying we have connected ***/
            
                $sql = "SELECT patientID, name, first_name, birthdate FROM patient";
            
                $result = $dbh->query($sql);
            
                  foreach ($dbh -> query($sql) as $row) {
                    echo "<tr>
                      <td> $row[patientID].</td>
                      <td><a href=patientVitalSigns.php?id=$row[patientID]>$row[name]</a>.</td>
                      <td> $row[first_name].</td>
                      <td> $row[birthdate].</td>
                    </tr>";
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

    <button class="button" id="addPatient" style= "margin-top: 5px; margin-bottom: 5px;">
      <i class="fas fa-user-plus"></i> Add new patient</button>
    <div id="modalPatient" class="modal">

      <!-- Modal content -->
     <div class="modal-content">
    
        <!-- form to add a new patient-->
        
        <form method="POST">
          <input type="hidden" name="newPatient" value="">
          <table id= "newPatientData" class="newPatientData">
            <tr class="data">
              <td>Surname</td>
              <td class="inputValue">
                <input type="text" name="surname" placeholder="Surname" required>
              </td>
            </tr>
            <tr class="data">
              <td>First name</td>
              <td class="inputValue">
                <input type="text" name="firstName" placeholder="First name" required>
              </td>
            </tr>
            <tr class="data">
              <td>Gender</td>
              <td class="inputValue">
                <input type="radio" name="gender" value="1" required> Male<br>
                <input type="radio" name="gender" value="2" required> Female<br>
              </td>
            </tr>
            <tr class="data">
              <td>Date of birth</td>
              <td class="inputValue">
                <input type="text" name="dateOfBirth" placeholder="YYYY-MM-DD" required>
              </td>
            </tr>
          </table>
          <input type="submit" name= "submit" value="Submit" style= "margin-top: 5px; margin-bottom: 5px;"> <button type="button" class="close" id="cancel" style= "margin-top: 5px; margin-bottom: 5px;">Cancel</button>
        </form>
      </div>

    </div>
  </div>

  <?php

include('pdo.inc.php');

$conn = new mysqli ($hostname, $username, $password, $dbname);
error_reporting(0);

/*if($conn->connect_error){
  echo "Connection failed!";
}

else{
  echo "Connection successful!";
}*/

$surName = $_POST['surname'];
$firstName = $_POST['firstName'];
$gender = $_POST['gender'];
$dateOfBirth = $_POST['dateOfBirth'];

  if(isset($_POST['submit'])){
   $sql = "INSERT INTO patient (name, first_name, gender, birthdate)
    values('$surName', '$firstName', '$gender', '$dateOfBirth') ";

    echo "<meta http-equiv='refresh' content='0'>";
  
    if($conn->query($sql) === TRUE){
    
      header("location: patientList.php");
      exit();
      
      $conn->close();
    

    }

    /*else{
        echo "Insertion into database failed!";
    }*/

  }

  $conn->close();

?>

  <script>
    var modal = document.getElementById('modalPatient');
    modal.style.display ="none";

    var addBtn = document.getElementById("addPatient");
    var span = document.getElementsByClassName("close")[0];
    addBtn.onclick = function () {
      modal.style.display = "block";
    }

    span.onclick = function () {
      modal.style.display = "none";
    }

    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>
</html>