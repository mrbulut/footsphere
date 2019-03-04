<?php
$OperationManagerNavBarArray = array("Dashboard", "Products", "Requests", "Messages", "Producers", "Settings", "Help");

$navBarResult = null;
foreach ($OperationManagerNavBarArray as $key => $value) {
    if ($url == $value)
        $navBarResult = $navBarResult . '<li class="nav-item active"><a class="nav-link" 
href="admin.php?page=footsphere&' . $value . '">' . $value . '</a> </li>';
    else
        $navBarResult = $navBarResult . '<li class="nav-item"><a class="nav-link" 
href="admin.php?page=footsphere&' . $value . '">' . $value . '</a> </li>';
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
