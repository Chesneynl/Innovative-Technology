<?php
session_start();
//build connection link
require_once('scripts/config.php');

// Check if logedin user is the admin
if (!$_SESSION['admin']) {
    header('Location: getInstaPhotos.php');
    exit();
}

if (isset($_GET['ui'])) {
    unset($_SESSION['editUserId']);
    $_SESSION['editUserId'] = $_GET['ui'];
}

$message = "";
$message2 = "";




//stap 3 Build query
if (isset($_POST['personal_change'])) {
    // for every $_POST set a variable equeal to the name of the input.
    foreach( $_POST as $key => $value )
    {
        ${$key} = $value;

    }

    // Validation for the inputs given by the user
    if (strlen($firstname) > 22 || strlen($lastname) > 40) {
        $message = "Uw voor en/of achternaam mag niet te lang zijn.";
    }
    elseif (!ctype_alpha($firstname)) {
        $message = "Uw voornaam mag geen nummers bevatten.";
    }
    elseif (!ctype_digit($tel)) {
        $message = "Uw telefoonnummer moet uit nummers bestaan";
    }
    elseif (strlen($address) > 50 ) {
        $message = "Uw adres mag niet te lang zijn.";
    }
    // If everything goes well Update database with the given input by the user
    else {
        $updateQuery = "UPDATE users SET firstname = '" . $firstname . "',
            lastname = '" . $lastname . "',
            address = '" . $address . "',
            city = '" . $city . "',
            homenumber = '" . $nr . "',
            phonenumber = '" . $tel . "',
            admin = '" . $accountType . "'
            WHERE userid = '" . $_SESSION['editUserId'] . "'";

        if (mysqli_query($db, $updateQuery)) {
            $message = "Klant succesvol aangepast";
        } else {
            $message = "Er is iets misgegaan!";
        }
    }
}
if (isset($_POST['login_change'])) {
    $email = $_POST['email_login'];
    $password = $_POST['password_login'];

    // Set protected password
    $md5LoginPassowrd = md5($password);

    if(strlen($password) < 6)
    {
        $message2 = "Uw wachtwoord moet minimaal uit 6 tekens bestaan.";
    }
    else {
        $updateQuery = "UPDATE users SET email = '" . $email . "',
            password = '" . $md5LoginPassowrd . "'
            WHERE userid = '" . $_SESSION['userid'] . "'";

        if (mysqli_query($db, $updateQuery)) {
            $message2 = "Inloggegevens succesvol aangepast";
        } else {
            $message2 = "Er is iets misgegaan!";
        }
    }
}

    $query = mysqli_query($db, "SELECT * FROM users WHERE userid = '" . $_SESSION['editUserId'] . "'");


    $row = mysqli_fetch_row($query);
//stap5 close database connection
mysqli_close($db);
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
        <?php include 'scripts/menu.html'; ?>
    </main>
</div>
<div class="wrapper">
    <div id="content">
        <div id="register_content">
            <div id="register">
                    <form method="post" attribute="post" action="edituser.php?ui=<?php echo $_SESSION['editUserId']?>" class="basic-grey">
                        <h1>Account wijzigen<span>Wijzig hier uw persoonlijke gegevens.</span></h1>
                        <?php echo $message; ?>
                        <p><label><span>Voornaam</span>
                                <input type="text" name="firstname" value="<?php echo $row[1]; ?>"></p>
                        </label>
                        <p><label><span>Achternaam</span>
                                <input type="text" name="lastname" value="<?php echo $row[2]; ?>"></p>
                        </label>
                        <p><label><span>Adres</span>
                                <input type="text" name="address" value="<?php echo $row[4]; ?>"></p>
                        </label>
                        <p><label><span>Nr</span>
                                <input type="text" name="nr" value="<?php echo $row[6]; ?>"></p>
                        </label>
                        <p><label><span>Woonplaats</span>
                                <input type="text" name="city" value="<?php echo $row[5]; ?>"></p>
                        </label>
                        <p><label><span>Telefoonnummer</span>
                                <input type="text" name="tel" value="<?php echo $row[8]; ?>"></p>
                        </label>
                        <?php if ($_SESSION['admin']) { ?>
                        <p><label><span>Account type</span>
                        <select name="accountType">
                            <option value="0">Gebruiker</option>
                            <option value="1" <?php if ($row[9]) {echo "selected"; } ?>>Admin</option>
                        </select>
                        </p>
                        </label>
                        <?php } ?>
                        <label><span>&nbsp;</span>
                            <input type="submit" class="button" name="personal_change" value="Opslaan"></label>
                    </form>

            </div>
            <div id="login">
                <form method="post" attribute="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basic-grey">
                    <h1>Inloggegevens<span>U kunt hier uw inloggegevens wijzigen.</span></h1>
                    <?php echo $message2; ?>
                    <p><label><span>Email</span>
                            <input type="text" id="name" name="email_login" value="<?php echo $row[3]; ?>"></p>
                    </label>
                    <label><span>Wachtwoord</span>
                        <input type="password" id="name" name="password_login" ></p>
                    </label>
                    <label><span>&nbsp;</span>
                        <input type="submit" class="button" name="login_change" value="Opslaan"></label>
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
</body>
</html>
