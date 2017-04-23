<?php

$todayMinus1Day = date('Y-m-d', strtotime("-1 day"));
//Get all classes that are still open
$selectQuery2 = "SELECT * FROM appointments JOIN users ON appointments.userid = users.userid WHERE app_date > '$todayMinus1Day'  AND users.userid = $userid";


$query2 = mysqli_query($db,$selectQuery2);

// Set every user in a table row
while($row = mysqli_fetch_array($query2))
{
    $startDate = date('Y-m-d' , strtotime($row['app_date']. "-2 weeks"));

    echo "<li>";
    echo "<div class='class'>" . $row['class'] . "</div>";
    echo "<div class='date'>" . "<span>" . "Einddatum :" . "</span>" . $row['app_date'] . " Tijd : " . $row['app_time'] . "</div>";
    echo "<div class='button '>" . "<a  class='fa fa-minus-square' href='index.php?ai=".$row['app_id']."'>" . "" . "</a>" . "</div>";

    echo "<span class='addtocalendar atc-style-blue' data-calendars='Google Calendar'>
    <a class='atcb-link fa fa-plus-square'></a>
    <var class='atc_event'>
        <var class='atc_date_start'>" . $startDate . " " . $row['app_time'] . "</var>";

    echo "<var class='atc_date_end'>" . $row['app_date'] . " " . $row['app_time'] . "</var>";
    echo "<var class='atc_timezone'>" . "Europe/Amsterdam"  . "</var>";
    echo "<var class='atc_title'>" . $row['class']  . "</var>";
    echo "<var class='atc_description'>" . " " . "</var>";
    echo "<var class='atc_location'>" . "Rotterdam" . "</var>";
    echo "<var class='atc_organizer'>" . "Hogeschool Rotterdam" . "</var>";
    echo "<var class='atc_organizer_email'>" . $row['email'] . "</var>";
    echo "</var> </span>";

    echo "</li>";
}



?>
