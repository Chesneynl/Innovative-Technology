<?php

    echo $message;
    echo "<table border='1'>
        <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Adres</th>
        <th>Woonplaats</th>
        <th>Huisnr</th>
        <th>Telefoonnummer</th>
        </tr>";

    // Set every user in a table row
    while($row = mysqli_fetch_array($query))
    {
        $userid = $row['userid'];
        echo "<tr>";
        echo "<td>" . "<a href='edituser.php?ui=".$userid."'>" . $row['firstname'] . "</a>" . "</td>";
        echo "<td>" . $row['lastname'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['address'] . "</td>";
        echo "<td>" . $row['city'] . "</td>";
        echo "<td class='homenr'>" . $row['homenumber'] . "</td>";
        echo "<td>" . $row['phonenumber'] . "</td>";
        echo "<td>" . "<a href='klant.php?ui=".$userid."'>" . "Verwijderen" . "</a>" . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    mysqli_close($db);

?>