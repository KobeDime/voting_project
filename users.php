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
          <a href="cpanel.php" class="navbar-brand headerFont text-lg">KobeEllect Voting System</a>
        </div>
      </div> <!-- end of container -->
    </nav>

    <div class="container" style="padding-top:70px;">
      <h4 class="text-center">Displaying Top 10 Voters</h4>
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-bordered table-hover">
            <tr>
              <th><strong>Voter's Full Name</strong></th>
              <th><strong>E-Mail</strong></th>
              <th><strong>Voter ID</strong></th>
            </tr>
            <?php
            require('config.php');

            // Establish Connection
            $conn = mysqli_connect($hostname, $username, $password, $database);

            // Check connection
            if (!$conn) {
              die("Connection Failed: " . mysqli_connect_error());
            }

            // SQL query to select the top 10 voters
            $sql = "SELECT * FROM voting_system.tbl_users ORDER BY id LIMIT 10";
            $query = mysqli_query($conn, $sql);

            // Check if there are results
            if (mysqli_num_rows($query) > 0) {
              while ($row = mysqli_fetch_assoc($query)) {
                $full_name = $row['full_name'];
                $email = $row['email'];
                $voter_id = $row['voter_id'];
                echo "
                <tr>
                    <td>$full_name</td>
                    <td>$email</td>
                    <td>$voter_id</td>
                </tr>   
                ";
              }
            } else {
              echo "<tr><td colspan='3'>No voters found.</td></tr>";
            }

            mysqli_close($conn);
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
