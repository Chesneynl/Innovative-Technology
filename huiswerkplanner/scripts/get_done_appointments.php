<?php

//Get all classes that are still done
$selectQuery3 = "SELECT * FROM appointments JOIN users ON appointments.userid = users.userid WHERE app_date < '$currentDate'  AND users.userid = $userid";

$query3 = mysqli_query($db,$selectQuery3);


// Set every user in a table row
while($row = mysqli_fetch_array($query3))
{
    echo "<li>";
    echo "<div class='class'>" . $row['class'] . "</div>";
    echo "<div class='date'>" . "<span>" . "Einddatum :" . "</span>" . $row['app_date'] . " Tijd : " . $row['app_time'] . "</div>";
    echo "<div class='button '>" . "<a  class='fa fa-minus-square' href='index.php?ai=".$row['app_id']."'>" . "" . "</a>" . "</div>";
    echo "</li>";
}



?>
