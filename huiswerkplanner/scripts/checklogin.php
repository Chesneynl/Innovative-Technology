<?php
$loginMessage = "";

// Show links that want to be seen when either a customer or admin logs in
if (isset($_SESSION['logedin'])) {
    if ($_SESSION['admin']) { ?>
        <a href="klant.php"></a>
    <?php }?>
        <a href="index.php">Home</a>
        <a href="editaccount.php">Account</a>
        <a href="logout.php">Uitloggen</a>

<?php
    // Show welcome back message with the given name from $_SESSION
    //$loginMessage = $_SESSION['firstname'] . "!";
    echo "<span>" . $loginMessage . "</span>"; } ?>
<?php
// When you are not loggedin show the links registreren and inloggen
if (!isset($_SESSION['logedin'])){?>
    <a href="register.php">Registreren Inloggen</a>
    <?php }?>
