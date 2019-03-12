<?php
$OperationManagerNavBarArray = array("Dashboard", "Orders", "Products", "Requests", "Messages", "Producers", "Settings", "Help");

$link = explode("?page=", $_SERVER['REQUEST_URI'])[1];
$url = explode("&", $link);
if (!$url[1]) {
    $url[1] = "Dashboard";
}

$navBarResult = null;
foreach ($OperationManagerNavBarArray as $key => $value) {

    $click = "nav-item";
    if ($url[1] == $value) {
        $click = "nav-item active";
    }

    if ($_SESSION['role'] == "producer") {
        if ($value == "Settings")
            $value = "Profil";
        if ($value == "Producers")
            continue;
        $navBarResult = $navBarResult . '<li class="' . $click . '"><a class="nav-link" href="admin.php?page=footsphere&' . $value . '">' . $value . '</a> </li>';

    } else {
        $navBarResult = $navBarResult . '<li class="' . $click . '"><a class="nav-link" href="admin.php?page=footsphere&' . $value . '">' . $value . '</a> </li>';
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Footsphere</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav">
        <?php echo $navBarResult; ?>
    </ul>

</nav>
