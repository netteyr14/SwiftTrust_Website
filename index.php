<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle/style.css">
    <title>SwiftTrust: Login</title>
</head>
<body>
    <div class="img-slider">
        <div class="slide">
            <img src="img/title.png">
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php
                include("php/config.php");
                if(isset($_POST['submit'])){
                    $cardNo = mysqli_real_escape_string($connect, $_POST['cardNo']);    
                    $pin = mysqli_real_escape_string($connect, $_POST['pin']);

                    $array_cardno_pin = array($cardNo, $pin);

                    $myQuery = mysqli_query($connect, "SELECT cardNo, pin FROM acctable");
                    $row = mysqli_fetch_all($myQuery);

                    if(in_array($array_cardno_pin, $row)){

                        $allinfo = mysqli_query($connect, "SELECT * FROM acctable WHERE cardNo = $cardNo AND pin = $pin");
                        $all_info = mysqli_fetch_assoc($allinfo);

                        $_SESSION['fname_carry'] = $all_info['fname'];
                        $_SESSION['lname_carry'] = $all_info['lname'];
                        $_SESSION['cardNo_carry'] = $all_info['cardNo'];
                        $_SESSION['pin_carry'] = $all_info['pin'];
                        $_SESSION['usrbln_carry'] = $all_info['usrbln'];
                        $_SESSION['transac_carry'] = $all_info['Transaction_Id'];
                        $_SESSION['valid'] = true;
                        header("Location: dashboard.php");
                    } else {
                        echo "<p>Incorrect Card No. or Pin!</p><br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Back</button>";
                    }
                }else{
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="cardNo">Card No.</label>
                    <input type="number" name="cardNo" id="cardNo" required>
                </div>

                <div class="field input">
                    <label for="pin">Pin</label>
                    <input type="password" name="pin" id="pin" autocomplete="new-password" required>
                </div>

                <div class="field">
                    <input class= "btn" type="submit" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account yet? <a href="register.php">Sign Up Here</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>