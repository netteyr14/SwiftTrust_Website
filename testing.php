<?php

    session_start();
    include("php/config.php");
    $cardNo = $_SESSION['cardNo_carry'];
    $query = "SELECT cardNo FROM acctable WHERE cardNo = $cardNo";
    $result = $connect->query($query);
    $row = mysqli_fetch_row($result);
    $myDataType = gettype((int)$row[0]);
    echo (int)$row[0];
 ?>