<?php
    // Destroy the session then redirect to the homepage
    session_start();
    session_destroy();
    header('Location: index.php');
?>
