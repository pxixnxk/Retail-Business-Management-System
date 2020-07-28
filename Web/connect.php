 <?php

 // 使用常量定义数据库基本信息

define("dbhost","localhost");
define("dbusername","root");
define("dbpass","root");
define("dbname",'rbms');
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

$conn = new mysqli(dbhost,dbusername,dbpass,dbname);

 if (!$conn)
 
 {
 echo "Failed!!!";
 die('Could not connect: ' . mysql_error());
 
 }
 else {

 }
 
?>