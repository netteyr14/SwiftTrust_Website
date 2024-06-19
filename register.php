<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle/style.css">
    <title>SwiftTrust: Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php
        
            include("php/config.php");
            if(isset($_POST['submit'])){
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $cardNo = $_POST['cardNo'];
                $pin = $_POST['pin'];

                //check card no.
                $check_cardNo = mysqli_query($connect, "SELECT cardNo FROM acctable WHERE cardNo = $cardNo");

                if(mysqli_num_rows($check_cardNo) !=0 ){
                    echo "<p>This Card No. already exist</p><br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Register Here!</button>";
                } else {
                    $default_balance = 0;
                    mysqli_query($connect, "INSERT INTO acctable(fname,lname,cardNo,pin, usrbln) VALUES('$fname','$lname',$cardNo,$pin, $default_balance)") or die("Error Occured!");

                    echo "<p>Account Registration Successful!</p><br>";
                    echo "<a href='index.php'><button class='btn'>Login Here!</button>";
                }
            }else{     
        ?>

            <header>Register</header>
            <form action="" method="post">

                <div class="field input">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="cardNo">Card No.</label>
                    <input type="number" name="cardNo" id="cardNo" required>
                </div>

                <div class="field input">
                    <label for="pin">Pin</label>
                    <input type="number" name="pin" id="pin" autocomplete="new-password" required>
                </div>

                <div class="field">
                    <input class= "btn" type="submit" name="submit" value="Confirm" required>
                </div>

                <div class="links">
                    Already have an Account? <a href="index.php">Login In Here</a>
                </div>

            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>