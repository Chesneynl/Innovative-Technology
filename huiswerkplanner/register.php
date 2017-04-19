<?php
session_start();
//Stap 1 : build connection link
require_once('scripts/config.php');

    // Initialize variables
    $message = "";
    $firstname = "";
    $lastname = "";
    $address = "";
    $register_email = "";
    $login_email = "";
    $password = "";
    $city = "";
    $tel = "";
    $homeNr = "";
    $accountFound = false;



if (isset($_POST['submit'])) {
    // For each element in the $_POST create a variable equal to its name and set all to html special characters.
    foreach( $_POST as $key => $value )
    {
        ${$key} = htmlspecialchars($value);

    }

    $md5RegisterPassowrd = md5($register_password);

    //Query used to check if a user with the same email already exist on line.
    $query = mysqli_query($db , "SELECT * FROM users WHERE email = '".$register_email."'");

    // Validation for the inputs given by the user

    if (strlen($firstname) > 22 || strlen($lastname) > 40) {
        $message = "Uw voor en/of achternaam mag niet te lang zijn.";
    }
    elseif (!ctype_alpha($firstname)) {
        $message = "Uw voornaam mag geen nummers bevatten.";
    }
    elseif (!ctype_digit($homeNr)) {
        $message = "Uw huisnummer moet uit nummers bestaan";
    }
    elseif (!ctype_digit($tel)) {
        $message = "Uw telefoonnummer moet uit nummers bestaan";
    }
    elseif (strlen($address) > 50 ) {
        $message = "Uw adres mag niet te lang zijn.";
    }
    elseif(strlen($register_password) < 6)
    {
        $message = "Uw wachtwoord moet minimaal uit 6 tekens bestaan.";
    }
    else if ($register_password != $repeat_password) {
        $message = "Wachtwoorden zijn niet gelijk aan elkaar.";
    }
    else if (mysqli_num_rows($query) > 0) {
        $message = "Er bestaat al een account met die email";
    }
    // If everything goes well insert into database with the given input by the user
    else {
        $query = "INSERT INTO users (firstname, lastname, email, address, city, homenumber, password,phonenumber)
        VALUES ('$firstname', '$lastname', '$register_email', '$address', '$city', '$homeNr', '$md5RegisterPassowrd', $tel)";

        if (mysqli_query($db, $query)) {
            $message = "U bent succesvol geregistreerd!";
        } else {
            $message =  "Er is iets misgegaan";
        }
    }
}

if (isset($_POST['submit_login'])) {

    $email = $_POST['login_email'];
    $password = $_POST['login_password'];
    $md5LoginPassowrd = md5($password);

    //Check if user exists with the user given input
    $query = mysqli_query($db , "SELECT * FROM users WHERE email = '".$email."' AND password = '".$md5LoginPassowrd."' ");

    // if the query returns more then 0 rows that means that the account exists.
    // If the user exists set a few $_SESSION variable that we can use to see if someone is logein or not.
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_row($query);

        $_SESSION['logedin'] = true;
        $_SESSION['userid'] = $row[0];
        $_SESSION['firstname'] = $row[1];
        $_SESSION['admin'] = $row[9];
        $accountFound = true;
        header('Location: index.php');
        exit();
    }
    else {
        $accountFound = false;
    }
}
//stap5 close database connection
mysqli_close($db);
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
        <div id="register_content">
        <div  class="col-md-6">
            <form method="post" attribute="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basic-grey">
                <h1>Registreren<span>Registreer om een afspraak te maken.</span></h1>
                <?php echo $message;?>
                <p><label><span>Voornaam</span>
                        <input type="text"  name="firstname"  value="<?php echo $firstname ?>"></p>
                </label>
                <label><span>Achternaam</span>
                    <input type="text"  name="lastname" value="<?php echo $lastname ?>"></p>
                </label>
                <label><span>Adres</span>
                    <input type="text"  name="address" value="<?php echo $address ?>"></p>
                </label>
                <label><span>nr</span>
                    <input type="text"  name="homeNr" value="<?php echo $homeNr ?>"></p>
                </label>
                <label><span>Woonplaats</span>
                    <input type="text"  name="city" value="<?php echo $city ?>"</p>
                </label>
                <label><span>Telefoonnummer</span>
                    <input type="text"  name="tel" value="<?php echo $tel ?>"></p>
                </label>
                <label><span>Email adres</span>
                    <input type="email"  name="register_email" value="<?php echo $register_email ?>"></p>
                </label>
                <label><span>Wachtwoord</span>
                    <input type="password"  name="register_password" value=""></p>
                </label>
                <label><span>Herhaal wachtwoord</span>
                    <input type="password"  name="repeat_password" value=""></p>
                </label>

                <label><span>&nbsp;</span>
                    <input type="submit" class="button" name="submit" value="Verzenden"></label>
                </p>
            </form>
        </div>
        <div class="col-md-6">
            <form method="post" attribute="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basic-grey">
                <h1>Inloggen<span>U kunt hier inloggen met uw gegevens</span></h1>
                <?php if (!$accountFound && isset($_POST['submit_login'])) {echo '<div class="fail_message"> Email en/of wachtwoord is onjuist!</div>';} ?>
                <p><label><span>Email</span>
                        <input type="text" id="name" name="login_email" placeholder="Email adres"></p>
                </label>
                <label><span>Wachtwoord</span>
                    <input type="password" id="name" name="login_password" placeholder="Wachtwoord"></p>
                </label>
                <label><span>&nbsp;</span>
                    <input type="submit" class="button" name="submit_login" value="Verzenden"></label>
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
