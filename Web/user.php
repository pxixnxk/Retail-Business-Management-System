<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>RBMS</title>

	<link rel="shortcut icon"  href="gt_favicon.png">
	
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="assets/css/main.css">

</head>

<head class="head">
<body class="home">
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
					<li><a class="btn-lg" href="logout.php">Log Out</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->
	
<?php  //Start the Session
session_start();
 require('connect.php');
 if(!isset($_SESSION['user']) && !isset($_POST['userid']) ) {
     header("Location:signin.php");
     exit;
 }

if (isset($_POST['userid']) and isset($_POST['password'])){

$username = $_POST['userid'];
$password = $_POST['password'];

$query = "SELECT * FROM `customers` WHERE cname ='$username' and cid ='$password'";
$result = $conn->query($query);
$count = mysqli_num_rows($result);

if ($count == 1){
$_SESSION['user'] = $password;
}else{
    // 跳转至登录界面，并告知用户用户名或密码错误
    header("Location: signin.php?login=false");
}
}
?>
	<!-- Header -->
	<header id="head">
		<div class="container">
			<div class="row">
				<div class="lead"><h1 class="log" style="font-size:35px; font-color:white; ">

<?php
if (isset($_SESSION['user']))
{
    $userid = $_SESSION['user'];
    $result = $conn->query("select cname from customers where cid = '$userid'");
    $username = $result->fetch_array()['cname'];

echo "Hi, " . $username . "!
";
}
?>	</h1>
</div>

<p><br><a class="btn btn-success btn-lg" role="button" href="view.php">Our Products</a></p><br><br><br><br><br>

<?php
echo "<br><br><br><br><br><br><br>";
?>

				</div>
		</div>




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
	<!-- /Header -->


</body>
</html>