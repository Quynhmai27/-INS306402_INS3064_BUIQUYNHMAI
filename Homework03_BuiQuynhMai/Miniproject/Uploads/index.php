<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirect('dashboard.php');
}

redirect('login.php');
?>