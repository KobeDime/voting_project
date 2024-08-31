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
  <link rel="icon" href="icons/favicon.png" type="image/png">
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

    .error {
      color: red;
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
          <a href="index.html" class="navbar-brand headerFont text-lg">KobeEllect Voting System</a>
        </div>
      </div> <!-- end of container -->
    </nav>
    <div class="container" style="padding-top:150px;">
      <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 text-center" style="border:2px solid gray;padding:50px;">
          <?php
          require('config.php');

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = test_input($_POST["voterName"] ?? '');
            $email = test_input($_POST["voterEmail"] ?? '');
            $voterID = test_input($_POST["voterID"] ?? '');
            $selection = test_input($_POST["selectedCandidate"] ?? '');

            $errors = [];

            if (empty($name)) $errors[] = 'Name is required.';
            if (empty($email)) $errors[] = 'Email is required.';
            if (empty($voterID)) $errors[] = 'Voter ID is required.';
            if (empty($selection)) $errors[] = 'Candidate selection is required.';

            if (empty($errors)) {
              $DB_HOST = "localhost";
              $DB_USER = "root";
              $DB_PASSWORD = "";
              $DB_NAME = "voting_system";

              $conn = @mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME)
                or die("Couldn't Connect to Database :");

              // Update SQL query to match actual column names
              $sql = "INSERT INTO voting_system.tbl_users (full_name, email, voter_id, voted_for) VALUES ('$name', '$email', '$voterID', '$selection');";

              if (mysqli_query($conn, $sql)) {
                echo "<img src='images/success.png' width='70' height='70'>";
                echo "<h3 class='text-info specialHead text-center'><strong> YOU'VE VOTED SUCCESSFULLY!</strong></h3>";
                echo "<a href='index.html' class='btn btn-primary' style='border-radius:0%'> <span class='glyphicon glyphicon-ok'></span> <strong> Finish</strong> </a>";
              } else {
                echo "<img src='images/error.png' width='70' height='70'>";
                echo "<h3 class='text-info specialHead text-center'><strong> SORRY! WE'VE SOME ISSUE..</strong></h3>";
                echo "<a href='index.html' class='btn btn-primary'> <span class='glyphicon glyphicon-ok'></span> <strong> Finish</strong> </a>";
              }

              mysqli_close($conn);
            } else {
              echo "<div class='error'>";
              foreach ($errors as $error) {
                echo "<p>$error</p>";
              }
              echo "<a href='javascript:history.back()' class='btn btn-warning' style='margin-top: 10px;'>Go Back</a>";
              echo "</div>";
            }
          }
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
