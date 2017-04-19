<?php


// Set every user in a table row
while($row = mysqli_fetch_array($query3))
{
    echo "<li>";
    echo "<div class='class'>" . $row['treatment'] . "</div>";
    echo "<div class='date'>" . "<span>" . "Einddatum " . "</span>" . $row['app_date'] . " " . $row['app_time'] . "</div>";
    echo "<div class='button '>" . "<a  class='fa fa-minus-square' href='index.php?ai=".$row['app_id']."'>" . "" . "</a>" . "</div>";
    echo "</li>";
}
echo "</table>";



?>
