<?php
@$pages = $_GET['pages'];
switch ($pages) {
    
    case 'dashboard':
        include "../pages/master/dashboard.php";
        break;

    default:
    include "../pages/master/dashboard.php";
        break;
}
?>