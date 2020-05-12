<html>
<head>
<title>CSC155 001DR Survey Thing</title>
<link rel="stylesheet" type="text/css" href="library/styles.css">
<?php

require ('library/functions.php');

// depending on the zone, call one of
//checkAccount("none");
//checkAccount("user");
checkAccount("admin");

// get connection object
$conn = getDBConnection();

// get the record information from $id
$result = lookupuserNameByID($conn, $_POST['id']);
$row = $result->fetch_assoc();
echo $row['username'];

?>
</head>
<body>
You are editing record number <?php echo showPost('id'); ?>
</body>
