<?php
include_once 'tools.php';

if (isset($_SESSION['current_email'])) {
    redirect('main.php');
} else {
    redirect('login.php');
}
?>