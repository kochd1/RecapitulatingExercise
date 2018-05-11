
<?php

include('pdo.inc.php');
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

?>