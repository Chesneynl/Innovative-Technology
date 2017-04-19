<?php
    session_start();
    require_once('scripts/config.php');
    $message = "";
    $searchItem = "";

    // Check if logedin user is the admin
    if (!$_SESSION['admin']) {
        header('Location: getInstaPhotos.php');
        exit();
    }

    // Get the user id given by the link when you click on a name and then delete that user from all tablesconnected with that userid
    if (isset($_GET['ui'])) {
        $deleteAppointments = "DELETE FROM appointments WHERE userid = '" . $_GET['ui'] . "'";
        $deleteUser = "DELETE FROM users WHERE userid = '" . $_GET['ui'] . "'";

        if (mysqli_query($db, $deleteAppointments) && mysqli_query($db, $deleteUser)) {
            $message = "Klant succesvol verwijderd!";
        } else {
            $message = "Er is iets misgegaan";
        }
    }
    //Get all users except the person watching the overview of customers
    $selectQuery = "SELECT * FROM users";

    // Search query to search something like a name or email
    if (isset($_POST['submit'])) {
        $selectQuery = "SELECT * FROM users WHERE firstname LIKE '" . "%" . $_POST['search'] . "%" .  "' OR email LIKE '" . "%" . $_POST['search'] . "%" . "'";
    }
    $query = mysqli_query($db,$selectQuery);

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
        <div id="inner_content">
            <div id="search_form">
            <form method="post" attribute="post" action="klant.php" class="basic-grey">
                <label><span>Zoeken</span>
                    <input type="text"  name="search"  placeholder="Zoek op naam of email adres">
                    <input type="submit" class="button" name="submit" value="Verzenden"></label>
                </label>
            </form>
                </div>
            <?php include('scripts/get_users.php');?>
        </div>
    </div>
</div>
<div id="footer_wrapper">
    <div id="footer"></div>
</div>
</body>
</html>
