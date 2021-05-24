<?php
require_once 'tools.php';

unset($_SESSION['current_email']);
unset($_SESSION['current_user']);
session_destroy();
header("Location: login.php");
?>
