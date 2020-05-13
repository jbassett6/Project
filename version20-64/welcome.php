<html>
<head>
<title>CSC155 001DR Survey Thing</title>
<link rel="stylesheet" type="text/css" href="library/styles.css">
<?php

require ('library/functions.php');

// depending on the zone, call one of
checkAccount("none");
//checkAccount("user");
//checkAccount("admin");

// get connection object
$conn = getDBConnection();

if (isset($_POST['selection']))
{
    if ($_POST['selection'] == 'Login')
    {
	if (checkAndStoreLogin($conn, $_POST['username'], $_POST['password']))
	{
	    header('Location: home.php');
	}
	else
	{
	    displayError("Login Failed");
	}
    }
    else if ($_POST['selection'] == 'Create Account')
    {
	header("Location: createAccount.php");
    }
}
 
?>
</head>
<body>

<hr>
This is the welcome page for our project.

If you don't have an account, you can create one <a href='createAccount.php'> here </a>. <br/>
This is where you can see the account database over the web <a href='showAccounts.php'> here </a>. <br/>

<center>^^^^ DEBUGGING LINKS ^^^^ </center>
<hr>


<form method='POST'>
<div style='border-width: 2px'>
<table id='userform'> 
<tr>
  <td>Username</td>
  <td><input type='text' name='username' /></td>
</tr>
<tr>
  <td>Password</td>
  <td><input type='password' name='password' /> </td>
</tr>
<tr>
  <td colspan='2' style='text-align: center; background-color: white;'> 
    <input type='submit' name='selection' value='Login' />
     &nbsp; &nbsp;
    <input type='submit' name='selection' value='Create Account' />
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
