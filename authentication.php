<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KobeEllect Voting System</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
  <style>
    .headerFont {
      font-family: 'Ubuntu', sans-serif;
      font-size: 24px;
    }

    .subFont {
      font-family: 'Raleway', sans-serif;
      font-size: 14px;
    }

    .specialHead {
      font-family: 'Oswald', sans-serif;
    }

    .normalFont {
      font-family: 'Roboto Condensed', sans-serif;
    }
  </style>
</head>
<body>
  <div class="container">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-header">
          <a href="index.html" class="navbar-brand headerFont text-lg">KobeElect Voting System</a>
        </div>
        <div class="collapse navbar-collapse" id="example-nav-collapse">
          <button type="submit" class="btn btn-success navbar-right navbar-btn"><span class="normalFont"><strong>Admin Panel</strong></span></button>
        </div>
      </div>
    </nav>
    <div class="container" style="padding-top:150px;">
      <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 text-center" style="border:2px solid gray;padding:50px;">
          <?php
          // Credentials
          $hostname = "localhost";
          $username = "root";
          $password = "";
          $database = "voting_system";
          // Establish Connection
          $conn = mysqli_connect($hostname, $username, $password, $database);
          // Check Connection
          if (!$conn) {
            die("Connection Failed: " . mysqli_connect_error());
          }
          // UserInput Test
          function test_input($data, $conn)
          {
            $data = trim($data); // Remove extra spaces
            $data = stripslashes($data); // Remove backslashes
            $data = htmlspecialchars($data); // Convert special characters
            $data = mysqli_real_escape_string($conn, $data); // Escape special characters for SQL
            return $data;
          }
          if (empty($_POST['adminUserName']) || empty($_POST['adminPassword'])) {
            $error = "UserName or Password is Required.";
          } else {
            $admin_username = test_input($_POST['adminUserName'], $conn);
            $admin_password = test_input($_POST['adminPassword'], $conn);

            // Prepare and Execute SQL Statement
            $sql = "SELECT * FROM tbl_admin WHERE admin_username = ? AND admin_password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $admin_username, $admin_password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
              header("Location: cpanel.php");
              exit();
            } else {
              $error = "Sorry !! Authentication Failed";
              echo "<p class='alert alert-danger'><strong>$error</strong></p>";
              echo "<p class='normalFont text-primary'><strong>Your Combination of UserName and Password is Incorrect. Better, You contact the developer of the system.</strong></p>";
              echo "<br><a href='admin.html' class='btn btn-primary'><span class='glyphicon glyphicon-refresh'></span> <strong>Try Again</strong></a>";
            }
            // Close Statement
            $stmt->close();
          }
          // Close Connection
          mysqli_close($conn);
          ?>
        </div>
        <div class="col-sm-4"></div>
      </div>
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>