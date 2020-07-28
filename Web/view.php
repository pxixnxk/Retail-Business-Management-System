<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Sergey Pozhilov (GetTemplate.com)">
    <title>Available Products</title>
    <link rel="shortcut icon" href="gt_favicon.png">
    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Custom styles for our template -->
    <link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen">
    <link rel="stylesheet" href="assets/css/main.css">

</head>

<body>
<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top headroom">
    <div class="container">
        <div class="navbar-header">
            <!-- Button for smallest screens -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span
                        class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="index.html">
                <div class="log">RBMS</div>
            </a>
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
<div class="container">
    <br>
    <br>
    <br>
    <div class="row">
        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <h3 class="thin text-center">Available Products</h3>
            <div class="search-container" align="right">
                <form action="view.php" method="get">
                    <input type="text" placeholder="Product ID" name="search_id">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <br>
            <?php
            require 'connect.php';
            $search_id = null;
            if(isset($_GET['search_id'])) {
                // 如果有设置要查询什么，则设置搜索 id

                $search_id = $_GET['search_id'];
            }
            $query = "select * from products";
            if($search_id != null) {
                $query = "select * from products where pid = '$search_id'";
            }
            $result = $conn->query($query);
            if ($result->num_rows == 0) {
                echo "<br>";
                if($search_id != null)
                    //如果搜索失败了，提示用户没有要搜索的产品
                    echo "<h5 class=\"thin text-center\">There is not any product math the id of $search_id.</h5>";
                else
                    echo "<h5 class=\"thin text-center\">There are none products available currently.</h5>";
            }
            foreach ($result as $row) {
                $id = $row['pid'];
                $name = $row['pname'];
                $qoh = $row['qoh'];
                $qoh_threshold = $row['qoh_threshold'];
                $original_price = $row['original_price'];
                $discnt_rate = $row['discnt_rate'];
                $sid = $row['sid'];
                $price = $original_price * (1 - $discnt_rate);

                print <<< END
<form action="purchase.php" method="post">
<div class="col-sm-6 col-md-3">
        <div class="thumbnail">
            <img class="img-responsive" height="300" width="300" src="/exp4/Web/assets/images/$id.jpg"
                 alt="通用的占位符缩略图"> 
                 <!--输出图片，图片名和 id 相同-->
            <div class="caption" style="text-align:center">
                <h3>$name</h3>
                <p style="font-size:22px;color:green">\$$price  
                <span style="font-size:16px;color:#8B8989;text-decoration: line-through"> \$$original_price </span> </p>
                <p> Stock: $qoh</p>
                <p>
                Amount:
                <input name="amount" class="input-group-sm" maxlength="5" style="width: 100px" type="number" value="0">
                <input name='id' type="hidden" value="$id">
                <br>
                <div style="text-align:center"> <button class="btn">Buy!  </button> </div>
                </p>
            </div>
        </div>
    </div>
</form>
END;

            }
            ?>

        </article>
        <!-- /Article -->

    </div>
</div>    <!-- /container -->
<br>
<br>
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