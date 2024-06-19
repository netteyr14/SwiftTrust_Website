<?php

use FFI\Exception;

    session_start();
    include("php/config.php");

    if(!isset($_SESSION['valid'])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle/style.css">
    <title>SwiftTrust: Update-Profile</title>
</head>
<body>
<div class="nav">
        <div class="logo">
            <p><a href="dashboard.php">Logo Icon</a></p>
        </div>

        <div class="right-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="php/logout.php"> <button class="btn">Log Out</button></a>

        </div>
    </div>

    <div class="container">
        <div class="box form-box">
            <?php
                    if(isset($_POST['submit1'])){
                    
                        $cardNo = $_SESSION['cardNo_carry'];
                        $pin_query = "SELECT pin FROM acctable WHERE cardNo = $cardNo";
                        $result = $connect->query($pin_query);
                        $row = mysqli_fetch_row($result);
                        $correct_pin = (int)$row[0];

                        $input_pin = (int)$_POST['pin'];
                    
                        if($input_pin == $correct_pin && $input_pin !=0 && $correct_pin!= 0){
                            $old_cardNo = $_SESSION['cardNo_carry'];
                            $fname = $_POST['fname'];
                            $lname = $_POST['lname'];
                            $new_cardNo = $_POST['cardNo'];

                            $update_query = mysqli_query($connect, "UPDATE acctable SET fname = '$fname', lname = '$lname', cardNo = $new_cardNo WHERE cardNo = $old_cardNo") or die("Error Occured!");

                            $_SESSION['fname_carry'] = $fname;
                            $_SESSION['lname_carry'] = $lname;
                            $_SESSION['cardNo_carry'] = $new_cardNo;
                            echo "<p>Changes are saved!</p><br>";
                            echo "<a href='dashboard.php'><button class='btn'>Dashboard</button>";
                            
                        } else {
                            echo "Incorrect Pin!";
                            echo "<a href='edit.php'><button class='btn'>Try Again!</button>";
                        }
                    } else {
                        
                        $trans = $_SESSION['transac_carry'];
                        $query = mysqli_query($connect, "SELECT * FROM acctable WHERE Transaction_Id = $trans");
                        while($result = mysqli_fetch_assoc($query)){
                            $res_fname = $result['fname'];
                            $res_lname = $result['lname'];
                            $res_cardNo = $result['cardNo'];
                        }
                        
            ?>
            <header>Update Profile</header>
            <form action="" method="post">
            <div class="field input">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?php echo $res_fname;?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?php echo $res_lname;?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="cardNo">Card No.</label>
                    <input type="number" name="cardNo" id="cardNo" value="<?php echo $res_cardNo;?>" required>
                </div>

                <div class="field input">
                    <label for="pin">Current Pin</label>
                    <input type="password" name="pin" id="pin" autocomplete="new-password" required>
                </div>

                <div class="field">
                    <input class= "btn" type="submit" name="submit1" value="Confirm" required>
                </div>
            </form>
        </div>

        <div class="box form-box">
            <?php
                if(isset($_POST['submit2'])){
                    $cardNo = $_SESSION['cardNo_carry'];
                    $pin_query = "SELECT pin FROM acctable WHERE cardNo = $cardNo";
                    $result = $connect->query($pin_query);
                    $row = mysqli_fetch_row($result);
                    $correct_pin = (int)$row[0];

                    $input_pin = (int)$_POST['pin'];

                    if($input_pin == $correct_pin && $input_pin !=0 && $correct_pin!= 0){
                        $cardNo = $_SESSION['cardNo_carry'];
                        $new_pin = $_POST['npin'];

                        $update_pin = mysqli_query($connect, "UPDATE acctable SET pin = $new_pin WHERE cardNo = $cardNo");
                            echo "<p>Changes are saved!</p><br>";
                            echo "<a href='dashboard.php'><button class='btn'>Dashboard</button>";
                    } else {
                        echo "Incorrect Pin!";
                        echo "<a href='edit.php'><button class='btn'>Try Again!</button>";
                    }
                } else {
            ?>
            <header>Change Pin</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="pin">New Pin</label>
                    <input type="password" name="npin" id="pin" autocomplete="new-password" required>
                </div>

                <div class="field input">
                    <label for="pin">Current Pin</label>
                    <input type="password" name="pin" id="pin" autocomplete="new-password" required>
                </div>

                <div class="field">
                    <input class= "btn" type="submit" name="submit2" value="Confirm" required>
                </div>
            </form>
        </div>
        <?php } ?>  
        <?php } ?>         
    </div>
</body>
</html>