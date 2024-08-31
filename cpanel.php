<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KobeElect Voting System</title>
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
          <a href="cpanel.php" class="navbar-brand headerFont text-lg">KobeElect Voting System</a>
        </div>
        <div class="collapse navbar-collapse" id="example-nav-collapse">
          <ul class="nav navbar-nav">
            <li><a href="nomination.html"><span class="subFont"><strong>Nominations</strong></span></a></li>
            <li><a href="changePassword.php"><span class="subFont"><strong>Change Password</strong></span></a></li>
            <li><a href="users.php"><span class="subFont"><strong>Voters</strong></span></a></li>
          </ul>
          <span class="normalFont"><a href="index.html" class="btn btn-danger navbar-right navbar-btn" style="border-radius:0%">Logout</a></span>
        </div>
      </div>
    </nav>
    <div class="container" style="padding:100px;">
      <div class="row">
        <div class="col-sm-12" style="border:2px outset gray;">
          <div class="page-header text-center">
            <h2 class="specialHead">ADMIN PANEL</h2>
            <p class="normalFont">The Voting Results</p>
          </div>
          <div class="col-sm-12">
            <?php
            require 'config.php';
            // Initialize vote counters
            $vote_counts = array(
              'JB' => 0,  // Joe Biden
              'DR' => 0,  // Donald Trump
              'RD' => 0,  // Ron DeSantis
              'NH' => 0,  // Nikki Haley
              'MP' => 0,  // Mike Pence
              'RK' => 0   // Robert F. Kennedy Jr.
            );
            // Establish connection
            $conn = mysqli_connect($hostname, $username, $password, $database);
            if (!$conn) {
              die("Error while connecting: " . mysqli_connect_error());
            }
            // Fetch and count votes
            $sql = "SELECT voted_for, COUNT(*) as count FROM tbl_users GROUP BY voted_for";
            $result = mysqli_query($conn, $sql);
            if ($result) {
              while ($row = mysqli_fetch_assoc($result)) {
                $candidate = $row['voted_for'];
                if (isset($vote_counts[$candidate])) {
                  $vote_counts[$candidate] = $row['count'];
                }
              }
            } else {
              echo "Error executing query: " . mysqli_error($conn);
            }
            // Display results
            foreach ($vote_counts as $candidate_code => $count) {
              $candidate_name = '';
              $progress_class = '';
              switch ($candidate_code) {
                case 'JB':
                  $candidate_name = 'Joe Biden';
                  $progress_class = 'progress-bar-danger';
                  break;
                case 'DR':
                  $candidate_name = 'Donald Trump';
                  $progress_class = 'progress-bar-info';
                  break;
                case 'RD':
                  $candidate_name = 'Ron DeSantis';
                  $progress_class = 'progress-bar-warning';
                  break;
                case 'NH':
                  $candidate_name = 'Nikki Haley';
                  $progress_class = 'progress-bar-success';
                  break;
                case 'MP':
                  $candidate_name = 'Mike Pence';
                  $progress_class = 'progress-bar-primary';
                  break;
                case 'RK':
                  $candidate_name = 'Robert F. Kennedy Jr.';
                  $progress_class = 'progress-bar-danger';
                  break;
              }
              $value = $count * 10;
              echo "<strong>$candidate_name</strong><br>";
              echo "
                <div class='progress'>
                  <div class='progress-bar $progress_class' role='progressbar' aria-valuenow=\"$value\" aria-valuemin=\"0\" aria-valuemax=\"100\" style='width: $value%'>
                    <span class='sr-only'>$candidate_code</span>
                  </div>
                </div>
              ";
            }
            // Total votes
            $total_votes = array_sum($vote_counts);
            echo "<hr>";
            echo "
              <div class='text-primary text-center'>
                <h3 class='normalFont'>TOTAL VOTES: $total_votes</h3>
              </div>
            ";
            mysqli_close($conn);
            ?>
          </div>
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
