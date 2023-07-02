<?php
session_start();
session_unset();//use unset() to unregister a session variable, i.e. unset ($_SESSION['varname']);.
session_destroy();
header('location:../index.php');
exit();

?>