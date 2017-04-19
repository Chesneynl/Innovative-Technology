<?php
session_start();
require_once('scripts/config.php');
$message = "";
$searchItem = "";

// Check if logedin user is the admin
if (!$_SESSION['admin']) {
    header('Location: register.php');
    exit();
}

if (isset($_POST['submit_class'])) {
    // For each element in the $_POST create a variable equal to its name and set all to html special characters.
    foreach( $_POST as $key => $value )
    {
        ${$key} = htmlspecialchars($value);
    }
}

if (isset($_POST['submit_class'])) {

    $timestamp = strtotime($time) + 30*60;
    $endtime = date('H:i:s', $timestamp);

    var_dump($date->modify('-2 week'));
    var_dump($endtime);

    //Check if date exists with user input
    $query = mysqli_query($db , "SELECT * FROM appointments WHERE app_time BETWEEN '$time' AND '$endtime'");
    $query2 = mysqli_query($db , "SELECT * FROM appointments WHERE app_time BETWEEN '$time' AND '$endtime'");
    $query3 = mysqli_query($db , "SELECT * FROM appointments WHERE app_time BETWEEN '$time' AND '$endtime'");

    // if the query returns more then 0 rows that means that the date exists.
    if (mysqli_num_rows($query) > 0) {
        $message= "Er is al een afspraak gemaakt op deze datum.";
    }
    else if($time < '13:00' || $time > '23:00') {
        $message = "Om deze tijd is de winkel niet geopend.";
    }
    else {
        $message= "Uw afspraak is gemaakt.";
        $query = "INSERT INTO appointments (app_date, userid, treatment, app_time, app_end_time)
        VALUES ('$date', '" . $_SESSION['userid'] . "', '$treatmentType', '$time', '$endtime')";

        if (mysqli_query($db, $query)) {
            $message = "Uw afspraak is gemaakt.";
        } else {
            $message =  "Er is iets misgegaan";
        }
    }
}

// Get the user id given by the link when you click on a name and then delete that user from all tablesconnected with that userid
if (isset($_GET['ai'])) {
    $deleteAppointments = "DELETE FROM appointments WHERE app_id = '" . $_GET['ai'] . "'";

    if (mysqli_query($db, $deleteAppointments)) {
        $message = "Afspraak succesvol verwijderd!";
    } else {
        $message = "Er is iets misgegaan";
    }
}
//Get all classes that are upcoming
$selectQuery = "SELECT * FROM appointments JOIN users ON appointments.userid = users.userid";

//Get all classes that are still open
$selectQuery2 = "SELECT * FROM appointments JOIN users ON appointments.userid = users.userid";

//Get all classes that are still done
$selectQuery3 = "SELECT * FROM appointments JOIN users ON appointments.userid = users.userid";

if (isset($_POST['submit'])) {
    $selectQuery = "SELECT * FROM appointments JOIN users ON appointments.userid = users.userid WHERE firstname LIKE '" . "%" . $_POST['search'] . "%" .  "' OR email LIKE '" . "%" . $_POST['search'] . "%" . "'ORDER BY app_date'" . "'";
}
$query = mysqli_query($db,$selectQuery);
$query2 = mysqli_query($db,$selectQuery2);
$query3 = mysqli_query($db,$selectQuery3);


?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
</head>
<body>
<div class="wrapper">
    <header>
        <div id="header_content">
            <div id="account_links">
                <?php include 'scripts/checklogin.php'; ?>
            </div>
        </div>
    </header>
</div>
<div class="wrapper">
    <div id="content">
        <div id="inner_content">

            <div id="search_form">
                <form method="post" attribute="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basic-grey">
                    <label><span>Zoeken</span>
                        <input type="text"  name="search"  placeholder="Zoek op naam of email adres">
                        <input type="submit" class="button" name="submit" value="Verzenden"></label>
                    </label>
                </form>
            </div>
            <div class="col-md-6 coming-classes ">
              <div class="section-title">
                Komende vakken
              </div>
              <ul>
                  <?php include('scripts/get_appointments.php');?>
              </ul>
            </div>
            <div class="col-md-6 coming-classes ">
              <div class="section-title">
                Openstaande vakken
              </div>
              <ul>
                  <?php include('scripts/get_open_appointments.php'); ?>
              </ul>
            </div>

            <div class="col-md-12 coming-classes ">
              <div class="section-title">
                Afgeronde vakken
              </div>
              <ul>
                  <?php include('scripts/get_done_appointments.php'); ?>
              </ul>
            </div>

            <div class="col-md-12">
                <form method="post" attribute="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basic-grey">
                    <h1>Knippen<span>Maak hier een afspraak om uw haren te laten knippen.</span></h1>
                    <?php echo $message;?>
                    <label><span>Soort behandeling</span>
                        <select name="treatmentType">
                            <option value="Knippen">Knippen</option>
                            <option value="Egale kleur" >Egale kleur</option>
                            <option value="Highlight" >Highlight</option>
                            <option value="Lowlight" >Lowlight</option>
                            <option value="Permanenteren knippen watergolven of fohnen" >Permanenteren knippen watergolven of fohnen</option>
                            <option value="Knippen & Egale kleur" >Knippen & Egale kleur</option>
                            <option value="Knippen, egale kleur met highlight of lowlight" >Knippen, egale kleur met highlight of lowlight</option>
                        </select>
                    </label>
                    <p><label><span>Datum</span>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"></p>
                    </label>
                    <p><label><span>Tijd</span>
                            <input type="time" name="time" value=""></p>
                    </label>
                    <label><span>&nbsp;</span>
                        <input type="submit" class="button" name="submit_class" value="Verzenden"></label>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="footer_wrapper">
    <div id="footer"></div>
</div>
</body>
</html>
