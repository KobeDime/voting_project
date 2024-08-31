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
                    <a href="index.html" class="navbar-brand headerFont text-lg">eVoting</a>
                </div>
                <div class="collapse navbar-collapse" id="example-nav-collapse">
                    <button type="submit" class="btn btn-success navbar-right navbar-btn">
                        <span class="normalFont"><strong>Admin Panel</strong></span>
                    </button>
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
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    // UserInput Test
                    function test_input($data, $conn)
                    {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        $data = mysqli_real_escape_string($conn, $data);
                        return $data;
                    }
                    // Fetch Data
                    if (empty($_POST['existingPassword']) || empty($_POST['newPassword'])) {
                        $error = "Fields Required.";
                    } else {
                        $old = test_input($_POST['existingPassword'], $conn);
                        $new = test_input($_POST['newPassword'], $conn);

                        // Update Password
                        $sql = "SELECT * FROM voting_system.tbl_admin WHERE admin_password='$old'";
                        $query = mysqli_query($conn, $sql);
                        $rows = mysqli_num_rows($query);

                        if ($rows == 1) {
                            // Given Password is Valid
                            $sql = "UPDATE voting_system.tbl_admin SET admin_password='$new' WHERE admin_username='admin'";
                            if (mysqli_query($conn, $sql)) {
                                // Successfully Changed
                                echo "<img src='images/success.png' width='70' height='70'>";
                                echo "<h3 class='text-info specialHead text-center'><strong> SUCCESSFULLY CHANGED.</strong></h3>";
                                echo "<a href='cpanel.php' class='btn btn-primary'> <span class='glyphicon glyphicon-ok'></span> <strong> Finish</strong> </a>";
                            } else {
                                echo "<p class='alert alert-danger'><strong>Error updating record: " . mysqli_error($conn) . "</strong></p>";
                            }
                        } else {
                            $error = "Old Password is Incorrect";
                            echo "<img src='images/error.png' width='70' height='70'>";
                            echo "<h3 class='text-info specialHead text-center'><strong> $error</strong></h3>";
                            echo "<a href='index.html' class='btn btn-primary'> <span class='glyphicon glyphicon-ok'></span> <strong> Finish</strong> </a>";
                        }
                    }

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