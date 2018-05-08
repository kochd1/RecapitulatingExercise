  <!DOCTYPE html>
<html>
<head>
<link href="style2.css" type="text/css" rel="stylesheet">
<title>Hospital Home</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div class="header">
  <h1>Spital Group-I</h1>
  <p>Care for life</p>
</div>

<div class="navbar">
    <a>Home</a>
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
      <h2>Patient list</h2>
      <h5>Select Patient:</h5>

      <table>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>First Name</th>
                <th>Birthdate</th>
            </tr>

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
            ?> </table>
    
      <h3>Settings</h3>
  <button class="button" id="addPatient"><i class="fas fa-user-plus"></i> New patient</button>
  <div id="modalPatient" class="modal">
      
        <!-- Modal content -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Add patient</h2>
          <form action="index.php" method="get">
      <input type="hidden" name="id" value="">
          <table>
        <tr>
            <td>Surname</td>
          <td><input type="text" name="time" placeholder=""></td>
        </tr>
              <tr>
                <td>First name</td>
                  <td><input type="text" name="time" placeholder=""></td>
              </tr>
              <tr>
                <td>Gender 1=male 2=female</td>
                  <td><input type="text" name="gender" placeholder=""></td>
              </tr>
              <tr>
                <td>Date of birth</td>
                  <td><input type="text" name="time" placeholder="YYYY-MM-DD"></td>
              </tr>
          </table>
          <input type="submit" value="Submit">
      </form>
        </div>
      
      </div>
      
  <script>
    var modal = document.getElementById('modalPatient');
    var btn = document.getElementById("addPatient");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
      modal.style.display = "block";
    }
    
    span.onclick = function() {
      modal.style.display = "none";
    }
    
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
      
  </div>


</body>
</html>
