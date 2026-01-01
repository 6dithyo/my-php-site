<?php
session_start();
session_unset();
session_destroy();
header("Location: /fitness_tracker/login.php");
exit();
?>
