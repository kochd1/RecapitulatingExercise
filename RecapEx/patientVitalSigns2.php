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
  <a href="#">Home</a>
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
      <h2>Patient list</h2>
      <h5>Select Patient:</h5>
      <div table>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Vorname</th>
                <th>Geburtsdatum</th>
            </tr></div>
            <?php
            try {
                $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
                /*** echo a message saying we have connected ***/
            
                $sql = "SELECT patientID, name, first_name, birthdate FROM patient";
            
                $result = $dbh->query($sql);
            
                  foreach ($dbh -> query($sql) as $row) {
                    echo "<tr>
                      <td> $row[patientID].</td>
                      <td><a href=viewPatient.php?id=$row[patientID]>$row[name]</a>.</td>
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

</body>
</html>
