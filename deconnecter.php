<?php

session_start();
session_destroy();
header("Location: authentifier.php");
exit();
?>