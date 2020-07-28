<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Sergey Pozhilov (GetTemplate.com)">
    <title>Available Products</title>
    <link rel="shortcut icon" href="../gt_favicon.png">
    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <!-- Custom styles for our template -->
    <link rel="stylesheet" href="../assets/css/bootstrap-theme.css" media="screen">
    <link rel="stylesheet" href="../assets/css/main.css">

    <style>
        th, td {
            text-align: center;
        }
    </style>
</head>

<body>
<?php // Do checking!
session_start();
if (!isset($_SESSION['admin'])) {
    // 判断管理员用户是否登录，若没有，则提示并跳转至登录界面
    echo "<script>
                        alert('You have to login first');
                        window.location.href='index.php';
              </script>";
    exit;
}

?>
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
                <li><a class="btn-lg" href="index.php">Home</a></li>
                <li><a class="btn-lg" href="../logout.php">Log out</a></li>
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
    <br>

    <div class="row">
        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <?php
            require '../connect.php';
            $query = null;
            echo " <h3 class=\"thin text-center\">Sale Report</h3>"."<br>";
            // 输出搜索框
            print <<<END
              <div class="flipkart-navbar-search smallsearch col-sm-12 col-xs-11">
                    <div class="row">
                    <form action="salereport.php" method="post">
                        <input class="flipkart-navbar-input col-xs-11" type="" placeholder="Search for Product" name="pname">
                        <button class="flipkart-navbar-button col-xs-1"type="submit">
                            <svg width="15px" height="15px">
                                <path d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868 11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0 2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895 6.487-6.467c0-3.572-2.905-6.467-6.487-6.467 "></path>
                            </svg>
                        </button>
                    </form>
                    </div>
                </div>
END;
            if (isset($_POST['pname'])) {
                // 如果设置了搜索物品的名称，那么进行搜索
                echo "<br><br>";
                $pname = $_POST['pname'];
                $query = "call report_monthly_sale('$pname')";
                $result = $conn->query($query);
                if ($result->num_rows == 0) {
                    echo "<font color='red'><h4 class=text-center>We couldn't find any product match the name of $pname.</h4></font>";
                } else {
                    echo "<h4 class=text-left>Search Result for $pname</h4>";
                    echo "<table class='table table-bordered table-striped table-hover'>";
                    print <<<END
    <thead>
    <th>
    id
    </th>
    <th>
    Product Name
    </th>
    <th>
    Month
    </th>
    <th>
    Year
    </th>
    <th>
    Quantity
    </th>
    <th>
    Total Price
    </th>
    <th>
    Average Price
    </th>
    </thead>
END;
                    // 输出搜索结果
                    foreach ($result as $row) {
                        echo "<tr>";
                        foreach ($row as $seg) {
                            echo "<td>$seg</td>";
                        }
                        echo "</tr>";
                    }

                }
                echo "</table>";

            }

            ?>
        </article>
        <!-- /Article -->
        
    </div>
</div>    <!-- /container -->
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