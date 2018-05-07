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
  <a style="text-decoration: none;">Home</a>
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
  <a>Einstellungen</a>
  <a href="logout.php" class="right">Logout</a>
</div>

<div class="row">
  <div class="side">
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
      <p>Add a patient</p>
      
  </div>


</body>
</html>
