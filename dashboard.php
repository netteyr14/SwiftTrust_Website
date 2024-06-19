<?php
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
    <title>SwiftTrust: Dashboard</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="dashboard.php">SwiftTrust</a></p>
        </div>

        <div class="right-links">
            <a href="edit.php">Profile</a>
            <a href="php/logout.php"> <button class="btn">Log Out</button></a>

        </div>
    </div>
    <div class="main">
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <?php
                        $cardNo = $_SESSION['cardNo_carry'];
                        $allinfo = mysqli_query($connect, "SELECT * FROM acctable WHERE cardNo = $cardNo");
                        $all_info = mysqli_fetch_assoc($allinfo);
                        $_SESSION['fname_carry'] = $all_info['fname'];

                        echo "Hello ".$_SESSION['fname_carry'].", Welcome!";
                    ?>
                </div>
                <div class="box">
                    <?php
                        $cardNo = $_SESSION['cardNo_carry'];
                        $allinfo = mysqli_query($connect, "SELECT * FROM acctable WHERE cardNo = $cardNo");
                        $all_info = mysqli_fetch_assoc($allinfo);
                        $_SESSION['usrbln_carry'] = $all_info['usrbln'];

                        echo "Current Balance: ".$_SESSION['usrbln_carry']." PHP";
                    ?>
                    <form action="" method="post">
                        <div class="field">
                            <center><input class= "btn" type="submit" name="submit" value="Reload Page" onclick="window.location.href='dashboard.php';" required></center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="slide-pos">
        <div class="box1">
            <?php
                include("php/config.php");
                if(isset($_POST['submit1'])){
                    $cardNo = $_SESSION['cardNo_carry'];
                    $usrbln_add = mysqli_query($connect, "SELECT usrbln FROM acctable WHERE cardNo = $cardNo");
                    $row = mysqli_fetch_row($usrbln_add);
                    $currentBal = (int)$row[0];
                    $addBal = (int)$_POST['depo_amt'];
                    $totalBal = $currentBal + $addBal;
                    if($addBal != 0){
                        $usrbln_update = mysqli_query($connect, "UPDATE acctable SET usrbln = $totalBal  WHERE cardNo = $cardNo");
                        $addBal = 0;
                        $allinfo = mysqli_query($connect, "SELECT * FROM acctable WHERE cardNo = $cardNo");
                        $all_info = mysqli_fetch_assoc($allinfo);
                        $_SESSION['usrbln_carry'] = $all_info['usrbln'];

                        echo "<center><h3><b>Amount Added!</b></h3></center>";
                    }
                } else {
            ?>
            <h2>Deposit</h2>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Amount:</label>
                    <input type="number" name="depo_amt" id="depo_amount" required>
                    <input class= "btn" type="submit" name="submit1" value="Proceed" required>
                </div>
            </form>
        </div>
        <div class="box1">
        <?php
                include("php/config.php");
                if(isset($_POST['submit2'])){
                    $cardNo = $_SESSION['cardNo_carry'];
                    $usrbln_sub = mysqli_query($connect, "SELECT usrbln FROM acctable WHERE cardNo = $cardNo");
                    $row = mysqli_fetch_row($usrbln_sub);
                    $currentBal = (int)$row[0];
                    $subBal = (int)$_POST['withd_amt'];
                    $totalBal = $currentBal - $subBal;
                    if($subBal != 0){
                        $usrbln_update = mysqli_query($connect, "UPDATE acctable SET usrbln = $totalBal  WHERE cardNo = $cardNo");
                        $subBal = 0;
                        $allinfo = mysqli_query($connect, "SELECT * FROM acctable WHERE cardNo = $cardNo");
                        $all_info = mysqli_fetch_assoc($allinfo);
                        $_SESSION['usrbln_carry'] = $all_info['usrbln'];

                        echo "<center><h3><b>Amount Deducted!</b></h3></center>";
                    }
                } else {
            ?>
            <h2>Withdrawal</h2>
            <form action="" method="post">
            <div class="field input">
                <label for="username">Amount:</label>
                <input type="number" name="withd_amt" id="withd_amount" required>
                <input class= "btn" type="submit" name="submit2" value="Proceed" onclick="window.location.href='dashboard.php';" required>
            </div>
            </form>
        </div>
        <div class="box1">
        <?php
                include("php/config.php");
                if(isset($_POST['submit3'])){
                    $cardNo = $_SESSION['cardNo_carry'];
                    $usrbln_sub = mysqli_query($connect, "SELECT usrbln FROM acctable WHERE cardNo = $cardNo");
                    $row = mysqli_fetch_row($usrbln_sub);
                    $currentBal = (int)$row[0];
                    $subBal = (int)$_POST['tran_amt'];
                    $totalBal = $currentBal - $subBal;
                    if($subBal != 0){
                        $usrbln_update = mysqli_query($connect, "UPDATE acctable SET usrbln = $totalBal  WHERE cardNo = $cardNo");

                        $transac = $_POST['user_id'];
                        $usrbln_receive = mysqli_query($connect, "SELECT usrbln FROM acctable WHERE Transaction_Id = $transac");
                        $receiver = mysqli_fetch_row($usrbln_receive);
                        $receive_bal = (int)$receiver[0];
                        $fromSender = $subBal;
                        $totalReceive = $receive_bal + $fromSender;

                        $receiveBal_update = mysqli_query($connect, "UPDATE acctable SET usrbln = $totalReceive  WHERE Transaction_Id = $transac");

                        $subBal = 0;
                        $allinfo = mysqli_query($connect, "SELECT * FROM acctable WHERE cardNo = $cardNo");
                        $all_info = mysqli_fetch_assoc($allinfo);
                        $_SESSION['usrbln_carry'] = $all_info['usrbln'];

                        echo "<center><h3><b>Amount Transfered!</b></h3></center>";
                    }
                } else {
            ?>
            <h2>Transfer</h2>
            <form action="" method="post">
            <div class="field input">
                <label for="username">Transaction ID:</label>
                <input type="number" name="user_id" id="user_id" required>

                <label for="username">Amount:</label>
                <input type="number" name="tran_amt" id="tran_amount" required>
                <input class= "btn" type="submit" name="submit3" value="Proceed" required>
            </div>
            </form>
        </div>
        <?php }?>
        <?php }?>
        <?php }?>
    </div>

</body>
</html>