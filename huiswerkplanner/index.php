<?php
session_start();
require_once('scripts/config.php');
$message = "";
$searchItem = "";
$currentDate = date('Y-m-d');


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

    $message= "Uw afspraak is gemaakt.";
    $query = "INSERT INTO appointments (app_date, userid, class, app_time)
    VALUES ('$date', '" . $_SESSION['userid'] . "', '$class', '$time')";

    if (mysqli_query($db, $query)) {
        $message = "Uw afspraak is gemaakt.";
    } else {
        $message =  "Er is iets misgegaan";
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







?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link href="http://addtocalendar.com/atc/1.5/atc-style-blue.css" rel="stylesheet" type="text/css">
</head>
<body>

  <script type="text/javascript">(function () {
              if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
              if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
                  var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                  s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
                  s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
                  var h = d[g]('body')[0];h.appendChild(s); }})();
      </script>

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

                        <input type="text"  name="search"  placeholder="Zoek op naam van het vak">
                        <input type="submit" class="button" name="submit" value="Zoeken"></label>
                </form>
            </div>
            <?php echo $message;?>
            <?php
              if (isset($_POST['submit'])) {?>
            <div class="col-md-12 coming-classes search_results">
              <div class="section-title">
                Zoekresultaten
              </div>
              <ul>
                  <?php
                      include('scripts/search_results.php');
                    ?>
              </ul>
            </div>
            <?php
          }
         ?>
            <div class="upcoming-classes">
                <div class="col-md-6 coming-classes ">
                  <div class="section-title">
                    Komende vakken
                  </div>
                  <div class="section-subtitle">
                    Dit zijn de vakken die binnen nu en twee weken eraan komen.
                  </div>
                  <ul>
                      <?php include('scripts/get_appointments.php');?>
                  </ul>
                </div>

                <div class="col-md-6 coming-classes upcoming-section">
                  <div class="section-title">
                    Openstaande vakken
                  </div>
                  <div class="section-subtitle">
                    Dit zijn de vakken vanaf nu nog open staan.
                  </div>
                  <ul>
                      <?php include('scripts/get_open_appointments.php'); ?>
                  </ul>
                </div>
            </div>
            <div class="col-md-12 coming-classes ">
              <div class="section-title">
                Afgeronde vakken
              </div>
              <div class="section-subtitle">
                Dit zijn de vakken die de einddatum al bereikt hebben.
              </div>
              <ul>
                  <?php include('scripts/get_done_appointments.php'); ?>
              </ul>
            </div>

            <div class="col-md-12 add-class">
                <form method="post" attribute="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basic-grey">
                    <h1>Vak toevoegen</h1>


                    <p><label><span>Vak</span>
                            <input type="text" name="class" value=""></p>
                    </label>
                    <p><label><span>Datum</span>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"></p>
                    </label>
                    <p><label><span>Tijd</span>
                            <input type="time" name="time" value="17:00"></p>
                    </label>
                    <label><span>&nbsp;</span>
                        <input type="submit" class="button" name="submit_class" value="Toevoegen"></label>
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
