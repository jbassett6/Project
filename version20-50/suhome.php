<html>
<head>
<title>CSC155 001DR Survey Thing</title>
<link rel="stylesheet" type="text/css" href="library/styles.css">
<?php

require ('library/functions.php');

// depending on the zone, call one of
//checkAccount("none");
//checkAccount("user");
//checkAccount("admin");
checkaccount("superuser");
// get connection object
$conn = getDBConnection();

?>
</head>
<body>
<?php echo $_SESSION['username'] ?>, Welcome to the Superuser Homepage!
</body>
