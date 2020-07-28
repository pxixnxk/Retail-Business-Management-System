<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	<title>Admin Sign In</title>
	<link rel="shortcut icon"  href="../gt_favicon.png">
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="../assets/css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="../assets/css/main.css">

</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="../index.html"><div class="log">RBMS</div></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a class="btn-lg" href="../signin.php">User</a></li>
					<li><a class="btn-lg" href="signup.html">SIGN UP</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->

	<header id="head" class="secondary"></header>
	<!-- container -->
	<div class="container">
		<ol class="breadcrumb">
			<li><a href="../index.html">Home</a></li>
			<li class="active">Admin access</li>
		</ol>
		<div class="row">
			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">Sign in to ADMIN's account</h3>
                            <?php
                            // 如果有设置登录失败的参数，则提示用户面膜错误
                                if(isset($_GET['login']) && $_GET['login'] == 'false') {
                                    echo "<script>alert('Invalid Name or Password!');
                                    	location.href='adsignin.php';</script>";
                                }
                                // 如果在 session 中已经记录了用户当前的登录状态，则直接跳转至用户界面
                                if(isset($_SESSION['adminid'])) {
                                    header("Location index.php");
                                }
                            ?>
							<hr>
							
							<form method="POST" action="index.php">
								<div class="top-margin">
									<label>Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="username">
								</div>
								<div class="top-margin">
									<label>Password <span class="text-danger">*</span></label>
									<input type="password" class="form-control" name="password">
								</div>
								<hr>
								<div class="row">
									<div class="col-lg-4 text-right">
									<button class="btn btn-action" type="submit"><i class="fa fa-sign-in fa-lg"> Sign In</i></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</article>
			<!-- /Article -->
		</div>
	</div>	<!-- /container -->
	

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