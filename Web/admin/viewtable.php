<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Sergey Pozhilov (GetTemplate.com)">
    <title>View Tables</title>
    <link rel="shortcut icon" href="../gt_favicon.png">
    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <!-- Custom styles for our template -->
    <link rel="stylesheet" href="../assets/css/bootstrap-theme.css" media="screen">
    <link rel="stylesheet" href="../assets/css/main.css">

    <style>
        th,td{
            text-align: center;
        }
    </style>
</head>

<body>
<?php // Do checking!
session_start();
if (!isset($_SESSION['admin'])) {
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


    <div class="row">
        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <?php
            require '../connect.php';
            $query = null;
            if (!isset($_GET['tbname'])) {
                // 如果没有设置要查看哪张表，则显示所有的表的名称
                echo " <h3 class=\"thin text-center\">ALL TABLES</h3>"."<br>";
                $query = "show tables;";
                $result = $conn->query($query);
                echo "<table class='table table-bordered table-striped table-hover'>";
                echo "<thead><th>Table Name</th></thead>";
                while($segment = $result->fetch_row()) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<a href='viewtable.php?tbname=" . $segment[0] . "'>";
                    echo $segment[0] . "</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";

            }
            else {
                // 设置了要查看哪张表，则用写好的存储过程进行查询
                $tableName =  $_GET["tbname"];
                echo " <h3 class=\"thin text-center\">$tableName</h3>"."<br>";
                $index  = 0;
                // 使用 desc 获得表中所有列的列名
                $fieldNames = $conn->query("desc " . $tableName);
                echo "<table class='table table-bordered table-striped table-hover'>";
                echo "<thead>";
                foreach ($fieldNames as $fieldName) {
                    $fields[$index] = $fieldName["Field"];
                    $index++;
                    echo "<th>".$fieldName["Field"] . "</th>";
                }
                echo "</thead>";

                $sql = "call show_table('$tableName')";

                $result = $conn->query($sql);
                foreach ($result as $segment) {
                    echo "<tr>";
                    foreach ($fields as $field) {
                        echo "<td>";
                        echo $segment[$field] . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                echo "<br>"."<p><center><a role='button' href='viewtable.php'>Go Back</a></center></p>";

            }

            ?>

        </article>
        <!-- /Article -->

    </div>
</div>    <!-- /container -->
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