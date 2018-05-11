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
    <h5>Select Patient:</h5>

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

            <?php

/*include('pdo.inc.php');
error_reporting(0);

$SurName = $_POST['surname'];
$firstName = $_POST['firstName'];
$gender = $_POST['gender'];
$DateOfBirth = $_POST['dateOfBirth'];

if(!_POST['submit']){
    echo "All fields are required";
}

else{
    $sql = "INSERT into Patient (name, first_name, gender, birthdate)
    values('$SurName', '$firstName', '$gender', '$DateOfBirth') ";

    if(mysql_query($conn, $sql)){
    echo "Data creation successful";

    }

    else{
        echo"Something went wrong!";
    }
    }
*/
?>


    </table>

    <button class="button" id="addPatient" style= "margin-top: 5px; margin-bottom: 5px;">
      <i class="fas fa-user-plus"></i> Add new patient</button>
    <div id="modalPatient" class="modal">

      <!-- Modal content -->
     <div class="modal-content">
    
        <!-- form to add a new patient-->
        
        <form id="newPatientForm" action="" method='POST'>
          <input type="hidden" name="newPatient" value="">
          <table id= "newPatientData" class="newPatientData">
            <tr class="data">
              <td>Surname</td>
              <td class="inputValue">
                <input type="text" name="surname" placeholder="" required>
              </td>
            </tr>
            <tr class="data">
              <td>First name</td>
              <td class="inputValue">
                <input type="text" name="firstName" placeholder="" required>
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
          <input type="submit" value="Submit" style= "margin-top: 5px; margin-bottom: 5px;"> <button type="button" class="close" id="cancel" style= "margin-top: 5px; margin-bottom: 5px;">Cancel</button>
        </form>
      </div>

    </div>
  </div>

<!--onclick = "submitData()";-->

  <!--<script>
  fuction submitData(){
    document.getElementbyId("newPatientForm").submit();
  }
  </script>-->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
$("#submit").on('click', function (e) {
    e.preventDefault();
    var data = $("#newPatientData tr.data").map(function (index, elem) {
        var ret = [];
        $('.inputValue', this).each(function () {
            var d = $(this).val()||$(this).text();
            ret.push(d);
            console.log(d);
            if (d == "N/A") {
                console.log(true);
            }
        });
        return ret;
    });
    console.log(data);
    console.log(data[0]);
});

</script>-->
  <!-- Use jQuery to read data from table-->

<!--<script>
  $('id').each(function(row, tr){

    TableData = TableData
    + $(tr).find('td:eq(0)').text() + ' ' //Patient ID
    + $(tr).find('td:eq(1)').text() + ' ' //Name
    + $(tr).find('td:eq(2)').text() + ' ' //First Name
    + $(tr).find('td:eq(3)').text() + ' ' //Birthdate
    +'\n';


  });

  </script>-->

<!--script to handle modal-->

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

<!--footer of this page-->

  <div class="footer">
    <h6>With a call to Group-I Hospital, you have immediate access to our highly trained staff, 24 hours a day, seven days a week, who can assess an individual in crisis and arrange admission to the appropriate level of care.
    <br/> This confidential assessment and referral is free of charge. Whatever the need, at any time of the day or night, high quality care is as close as a telephone.
    <br/>Hospital Group-I, Legend street 22, 9999 Switzerland, Tel.: +41 99 000 00 00</h>
  </div>

</body>
</html>