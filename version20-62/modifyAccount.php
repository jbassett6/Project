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

// if there's no $result, display the error page

$row = $result->fetch_assoc();

// handle which button got us here
if ($_POST['selection'] == 'Edit')
{
    echo 'editing';
}
else if ($_POST['selection'] == 'Apply Changes')
{
    echo 'applying changes';
}
else if ($_POST['selection'] == 'Reset Changes')
{
    echo 'resetting changes';
}
else if ($_POST['selection'] == 'Cancel')
{
    echo 'cancelling';
}
else 
{
   echo 'unknown selection';
}

?>
</head>
<body>
DEBUG: You are editing record number <?php echo showPost('id'); ?>

<form method='POST'>
    <input type='hidden' name='id' value='<?php echo showPost('id'); ?>' />
<div style='border-width: 2px'>
<table id='userform'> 
<tr>
  <td>Username</td>
  <td><?php echo $row["username"]; ?></td>
</tr>
<tr>
  <td>Email</td>
  <td> <input type='text' name='email' value='<?php echo $row["email"]; ?>'/></td>
</tr>
<tr>
  <td colspan='2' style='text-align: center; background-color: white;'> 
    <input type='submit' name='selection' value='Apply Changes' />
    &nbsp;
    <input type='submit' name='selection' value='Reset Changes' />
    &nbsp;
    <input type='submit' name='selection' value='Cancel' />
  </td>
</tr>
<tr>
  <td colspan='2' style='text-align: center; background-color: lightred;'>
    Warning: This is class project and is not secure!  
  </td>
</tr>
</table>
</div>
</form>

</body>
</html>

