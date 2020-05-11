<html>
<head>
<title>CSC155 001DR Survey Thing</title>
<link rel="stylesheet" type="text/css" href="library/styles.css">
<?php

require ('library/functions.php');

// depending on the zone, call one of
//checkAccount("none");
checkAccount("user");
//checkAccount("admin");

// get connection object
$conn = getDBConnection();

?>
</head>
<body>
<?php echo $_SESSION['username'] ?>, welcome to your home page! If you are an
Admins, you can go to the Admin homepage by click the following link.<button onclick="document.location = 'adminhome.php'">Admin Homepage!</button> <br>
Superusers, you can go to the Superuser homepage by click the following link.<button
onclick="document.location = 'suhome.php'">Superuser Homepage!</button>

</body>
