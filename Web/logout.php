<?php
session_start();
// 销毁当前 session，跳转至主界面
session_destroy();
header('Location: signin.php');
?>