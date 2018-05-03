<html>
<head>
<link href="style.css" type="text/css" rel="stylesheet">

<div class="navbar">
  <a href="login.php">Logout</a>
</div>
</head>

<body>

<h1>List of patients</h1>

<table>
<tr>
    <th>patientID</th>
    <th>MRN</th>
    <th>name</th>
    <th>first_name</th>
    <th>gender</th>
    <th>birthdate</th>
</tr>

<?php
session_start();

// First, we test if user is logged. If not, goto main.php (login page).
if(!isset($_SESSION['user'])){
  header("Location: main.php");
  exit();
}

include('pdo.inc.php');

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    /*** echo a message saying we have connected ***/

    $sql = "SELECT * FROM patient";

    $result = $dbh->query($sql);

    // while($line = $result->fetch()){
    //   echo "<a href='viewPatient.php?id=".$line['patientID']."'>";
    //   echo $line['first_name']." ".$line['name'];

    //   echo "</a><br>\n";

      foreach ($dbh -> query($sql) as $row) {
        echo "<tr>
          <td> $row[patientID].</td>
          <td> $row[MRN].</td>
          <td>
          <a href=viewPatient.php?id=$row[patientID]>$row[name]</a>
           .</td>
          <td> $row[first_name].</td>
          <td> $row[gender].</td>
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

echo "<br>User =".$_SESSION['user'];
?>
<br />
<i><a href="logout.php">Logout</a></i>
