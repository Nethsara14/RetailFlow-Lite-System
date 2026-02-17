<?php
include "connection.php";

if (isset($_POST["n"])) {
    $brand_name = $_POST["n"];

    if (empty($brand_name)) {
        echo ("කරුණාකර Brand එකේ නම ඇතුළත් කරන්න.");
    } else if (strlen($brand_name) > 50) {
        echo ("Brand නම අකුරු 50 ට වඩා අඩු විය යුතුය.");
    } else {
        // දැනටමත් මෙම නමින් Brand එකක් තිබේදැයි බැලීම
        $brand_rs = mysqli_query($conn, "SELECT * FROM `brand` WHERE `name` = '".$brand_name."'");
        $brand_num = mysqli_num_rows($brand_rs);

        if ($brand_num > 0) {
            echo ("මෙම Brand එක දැනටමත් පද්ධතියේ පවතී.");
        } else {
            // අලුතින් ඇතුළත් කිරීම
            mysqli_query($conn, "INSERT INTO `brand` (`name`) VALUES ('".$brand_name."')");
            echo ("success");
        }
    }
} else {
    echo ("යම් වැරද්දක් සිදුවී ඇත.");
}
?>