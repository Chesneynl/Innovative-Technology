<?php
session_start();
require_once('scripts/config.php');

$message = "";
$message2 = "";

if (!$_SESSION['logedin']) {
    header('Location: register.php');
    exit();
}

if (isset($_POST['submit_hair'])) {
    // For each element in the $_POST create a variable equal to its name and set all to html special characters.
    foreach( $_POST as $key => $value )
    {
        ${$key} = htmlspecialchars($value);
    }
}

if (isset($_POST['submit_hair'])) {

    $timestamp = strtotime($time) + 30*60;
    $endtime = date('H:i:s', $timestamp);

    //Check if date exists with user input
    $query = mysqli_query($db , "SELECT * FROM appointments WHERE app_time BETWEEN '$time' AND '$endtime'");

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
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

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
<div id="menu_wrapper">
    <main>
        <ul>
            <li ><a href="index.php">Home</a></li>
            <li class="active"><a href="afspraak-maken.php">Afspraak maken</a></li>
        </ul>
    </main>
</div>
<div class="wrapper">
    <div id="content">
        <div id="inner_content">
            <div id="register">
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
                        <input type="submit" class="button" name="submit_hair" value="Verzenden"></label>
                    </p>
                </form>
            </div>
            <div id="login">
                <form method="post" attribute="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basic-grey">
                    <h1>Nagels<span>Maak hier een afspraak voor de bahndeling van uw nagels.</span></h1>
                    <?php echo $message2;?>
                    <label><span>Soort behandeling</span>
                        <select name="treatmentType_nails">
                            <option value="Acryl nieuwe set">Acryl nieuwe set</option>
                            <option value="Acryl vulling" >Acryl vulling</option>
                            <option value="Solar nieuwe set">Solar nieuwe set</option>
                            <option value="Solar vulling" >Solar vulling</option>
                            <option value="Gel nieuwe set">Gel nieuwe set</option>
                            <option value="Gel vulling" >Gel vulling</option>
                        </select>
                    </label>
                    <p><label><span>Datum</span>
                            <input type="date" name="date_nails" value="<?php echo date('Y-m-d'); ?>"></p>
                    </label>
                    <p><label><span>Tijd</span>
                            <input type="time" name="time_nails" value=""></p>
                    </label>
                    <label><span>&nbsp;</span>
                        <input type="submit" class="button" name="submit_nails" value="Verzenden"></label>
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
