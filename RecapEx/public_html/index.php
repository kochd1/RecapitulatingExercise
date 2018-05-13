<link href="style.css" type="text/css" rel="stylesheet">
<link href="style2.css" type="text/css" rel="stylesheet">

<div class="container">
  <div class="item"></div>
  <div>

    <?php
      session_start();
      // Initialisation of passwords for the database
      include('pdo.inc.php');
      // Read the credentials if given as POST parameters
      $user = '';
      $pwd = '';
      $message = '';
      $logged = false;

      if(isset($_SESSION['user'])){
        $logged = true;

        header("Location: patientList.php");
        exit();
      }
      if(!$logged){
        if(isset($_POST['user'])){
          $user = ($_POST['user']);
          }
        if(isset($_POST['pwd'])){
          $pwd = ($_POST['pwd']);
        }
        try {
          // Connect to the database
          $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

          // if the username is set, test if combination "username/password" is valid
          if($user !=''){
            // Initialise SQL query with place holders (:username and :password)
            $sql0 = "SELECT staff.staffID, staff.username, first_name, hashed_password
            FROM staff,credential
            WHERE staff.staffID = credential.staffID AND staff.username=:username AND hashed_password=sha(:password)";

            // parse the query and set the parameters for place holders.
            $statement0 = $dbh->prepare($sql0);
            $statement0->bindParam(':username', $user, PDO::PARAM_STR);
            $statement0->bindParam(':password', $pwd, PDO::PARAM_STR);

            // execute the query
            $result0 = $statement0->execute();

            // case if login was a success
            if($line = $statement0->fetch()){
            echo "<h1> staff : ".$line['staffID']."  ".$line['username']." ".$line['hashed_password']."</h1>\n";
            $logged=true;
            $_SESSION['user']= $line['username'];

            header("Location: patientList.php");

            exit();
            }
            else{ // if login failed
            $message= "Username and/or password faulty. Please try again!";
            }
            $dbh = null;
          }
        }
        catch(PDOException $e)
          {
            /*** echo the sql statement and error message ***/
            echo $e->getMessage();
          }
      }

      // the form is only displayed if the person is not logged.
      if(!$logged){

      ?>

      <h1>Welcome to Hospital Group-I</h1>
      <center>
        <div>
          <form method='POST'>
            <fieldset class="fieldset-auto-width" style="color: #008CBA;">
              <span class="inner-pre" style="font-size: 20px">
                <p>
                  <label for="Login" style="font-size: 30px">
                    <b>Login</b>
                  </label>
                </p>
                <p>
                  <label for="Credentials">
                    <strong>Please enter your credentials</strong>
                  </label>
                </p>
                <p>
                  <label for="Username">Username:</label>
                  <input type="text" name="user" class="form-control">
                </p>
                <p>
                  <label for="Password">Password:</label>
                  <input type="password" name="pwd" class="form-control">
                </p>
                <p>
                  <input type="submit" value="Log in" class="btn-login btn-block">
                </p>
              </span>
            </fieldset>

          </form>
        </div>
      </center>

      <?php
          echo "<p align = 'center'><b><font color = '#ff0000'>$message</font></b> </p>";
          }
          ?>