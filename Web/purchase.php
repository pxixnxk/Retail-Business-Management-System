<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"    content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
    <title>Available Products</title>
    <link rel="shortcut icon"  href="gt_favicon.png">
    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Custom styles for our template -->
    <link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
    <link rel="stylesheet" href="assets/css/main.css">


</head>

<body>

<?php // Do checking!
// 判断用户是否登录，如果没有登录，提示用户必须登录，并跳转至登录界面
session_start();
if(!isset($_SESSION['user'])) {
    echo "<script>
                    alert('You have to login first');
                    window.location.href='signin.php';
          </script>";
    exit;
}
// 判断用户是否有输入产品数量和产品id，如果没有，则提示并跳转至商品界面
if(!isset($_POST['amount']) || !isset($_POST['id'])) {
    echo "<script>
                    alert('You have to choose prodcut first!');
                    window.location.href='view.php';
          </script>";
}

?>
<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top headroom" >
    <div class="container">
        <div class="navbar-header">
            <!-- Button for smallest screens -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="index.html"><div class="log">RBMS</div></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li><a class="btn-lg" href="user.php">Home</a></li>
                <li><a class="btn-lg" href="logout.php">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- /.navbar -->

<header id="head" class="secondary"></header>
<!-- container -->
<div class="container" >
    <br>
    <br>
    <br>
    <div class="row">
        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <center>
            <?php
                require 'connect.php';
                $user = $_SESSION['user'];
                // Process to generate proper purchase id:
                $query = "select pur from purchases";
                // 这里先处理所有的 purchase id，生成一个新的 purchase id
                $result = $conn->query($query);
                $count = $result->num_rows;
                $var=sprintf("%03d", $count);
                $purid = "p".$var;
                $res = $result->fetch_all();
                foreach ($res as $id) {
                    if($id[0] == $purid) {
                        $count++;
                        $var=sprintf("%03d", $count);
                        $purid = "p".$var;
                    }
                }
                $id = $_POST['id'];
                $cid = $_SESSION['user'];
                $amount = $_POST['amount'];
                // 通过查询语句获得要买的产品的信息
                $query = "select * from products where pid = '$id'";
                if(isset($_SESSION['admin'])) {
                    $eid = $_SESSION['admin'];
                }
                // 若没有管理员登录，默认订单处理者为 e00
                else
                    $eid = "e00";
                $result = $conn->query($query);
                $row = $result->fetch_array();
                $name = $row['pname'];
                $qoh = $row['qoh'];
                $qoh_threshold = $row['qoh_threshold'];
                $original_price = $row['original_price'];
                $discnt_rate = $row['discnt_rate'];
                $sid = $row['sid'];
                $price = $original_price * (1 - $discnt_rate);
                $total_price = $price * $amount;
                $query = "call add_purchases('$purid','$cid','$eid','$id',$amount)";
                $result = $conn->query($query);
                if($result) {
                    if($qoh - $amount < $qoh_threshold) {
                        // 如果要补货，告诉用户补货了多少
                        $restock_amount = $qoh + $amount;
                        echo "<script>alert('Successful purchase!\\nYou bought $amount $name, the total price is \$ $total_price.\\nWe restocked $restock_amount $name.');
                            location.href='view.php';</script>";
                    }
                    else{
                        echo "<script>alert('Successful purchase!\\nYou bought $amount $name, the total price is \$ $total_price.');
                            location.href='view.php';</script>";
                        }
                } else {
                    if($amount > $qoh) {
                        echo "<script>alert('Purchase failed!!\\nSorry. We are currently low in stock, please try to buy less.');
                            location.href='view.php';</script>";
                    }
                    else if($amount <= 0 ) {
                        echo "<script>alert('Purchase failed!!\\nYou cannot buy 0 or negative amount!');
                            location.href='view.php';</script>";
                    }
                    else {
                        echo "<script>alert('Purchase failed!!\\nAn unknown error occured!');
                            location.href='view.php';</script>";
                    }
                }
            ?>
        </center>
        </article>
        <!-- /Article -->

    </div>
</div>	<!-- /container -->
<br>

<br>
<footer id="footer" class="top-space">

    <div class="footer1">
        <div class="container">
            <div class="row">

                <div class="col-md-6 widget">
                    <div class="widget-body">
                        <p class="text-left">
                            @2017152043, <a href="#">Retail Business Management System</a>
                        </p>
                    </div>
                </div>

            </div> <!-- /row of widgets -->
        </div>
    </div>

</footer>


</body>
</html>