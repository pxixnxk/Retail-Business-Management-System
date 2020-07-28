<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Sergey Pozhilov (GetTemplate.com)">
    <title>Re-Store</title>
    <link rel="shortcut icon" href="../gt_favicon.png">

    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">

    <!-- Custom styles for our template -->
    <link rel="stylesheet" href="../assets/css/bootstrap-theme.css" media="screen">
    <link rel="stylesheet" href="../assets/css/main.css">

</head>

<body class="home">
<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top headroom">
    <div class="container">
        <div class="navbar-header">
            <!-- Button for smallest screens -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span
                    class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="../index.html">
                <div class="log">RBMS</div>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li><a class="btn-lg" href="../logout.php">Log out</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- /.navbar -->
<?php //Start the Session
session_start();
require('../connect.php');

// 判断用户有没有键入密码，如果有，则进行登录操作
if (isset($_POST['username']) and isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT eid FROM `employees` WHERE ename = '$username' and eid ='$password'";
    $result = $conn->query($query);
    $count = mysqli_num_rows($result);


    // 默认密码和用户名相等
    if ($count == 1) {
        // 在 session 中记录管理员用户的 id
        $_SESSION['admin'] = $username;

    } else {
        
        // 密码错误，跳转至登录界面，login = false 参数用来在登录界面显示密码错误的报错信息
        $fmsg = "Invalid Login Credentials.";
        header('Location: adsignin.php?login=false');
    }
}
// 如果没输入密码，检查是否已经登录，没有登录则跳转至登录界面
else if(!isset($_SESSION['admin'])) {
    header('Location: adsignin.php');
}
$adminid = $_SESSION['admin'];
$adminname = $conn->query("select ename from employees where ename = '$adminid'")->fetch_row()[0];
?>


<!-- Header -->
<header id="head">
    <div class="container">
        <div class="row">
            <div class="lead"><h1 class="log" style="font-size:30px; font-color:white; ">

                    Welcome, <?php echo "$adminname"; ?>!
                </h1>
            </div>
            <br><p><a class="btn btn-success btn-lg" role="button" href="viewtable.php">View tables</a></p>
            <p><a class="btn btn-success btn-lg" role="button" href="salereport.php">Sale report</a></p><br><br><br>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
<!-- /Header -->


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
</header>

</body>
</html>