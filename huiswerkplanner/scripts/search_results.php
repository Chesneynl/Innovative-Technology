<?php
$selectQuery4 = "";


$selectQuery4 = "SELECT * FROM appointments JOIN users ON appointments.userid = users.userid WHERE class LIKE '" . "%" . $_POST['search'] . "%" .  "' ";

$query4 = mysqli_query($db,$selectQuery4);

// Set every user in a table row
while($row = mysqli_fetch_array($query4))
{
    echo "<li>";
    echo "<div class='class'>" . $row['class'] . "</div>";
    echo "<div class='date'>" . "<span>" . "Einddatum " . "</span>" . $row['app_date'] . " " . $row['app_time'] . "</div>";
    echo "<div class='button '>" . "<a  class='fa fa-minus-square' href='index.php?ai=".$row['app_id']."'>" . "" . "</a>" . "</div>";
    echo "</li>";
}



?>
