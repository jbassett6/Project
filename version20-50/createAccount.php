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

if (isset($_POST['selection'])) // form loaded itself
{
    if ($_POST['selection'] == "Create Account") // insert new record chosen
    {
	if ($_POST['password'] == $_POST['confirm'])
        {
	    // build SQL command SECURELY
            // prepare
	    $stmt = $conn->prepare("INSERT INTO users 
                       (username, encrypted_password, usergroup, email,
firstname, lastname) 
                       VALUES (?, ?, ?, ?, ?, ?)" );
	    // bind variable names and types
	    $stmt->bind_param("ssssss", $username, $encrypted_password, 
                                  $usergroup, $email, $firstname, $lastname);

	    $username=$_POST['username'];
	    $encrypted_password=password_hash($_POST['password'], 
                                          PASSWORD_DEFAULT);
	    $usergroup=$_POST['usergroup'];
	    $email=$_POST['email'];
	    $firstname=$_POST['firstname'];
	    $lastname=$_POST['lastname'];

	    // put the statement together and send it to the database
	    $stmt->execute();
            header("Location: welcome.php");
	}
	else 
	{
	    displayError("Passwords don't match");
        }
	    
    }
    if ($_POST['selection'] == "Cancel") // insert new record chosen
    {
        header("Location: welcome.php");
    }
}
?>

</head>
<body>

<form method='POST'>
<div style='border-width: 2px'>
<table id='userform'> 
<tr>
  <td>Username</td>
  <td><input type='text' name='username' <input name='username' value='<?php echo showPost("username")?>' /></td>
</tr>
<tr>
  <td>Group</>
  <td>
        <input type='radio' name='usergroup' value='admin'> Admin
        <input type='radio' name='usergroup' value='user' checked> User
	<input type='radio' name='usergroup' value='superuser' > Superuser
 </td>

<tr>
  <td>Password</td>
  <td><input type='password' name='password' <input name='password' value='<?php echo showPost("password")?>' /> </td>
</tr>
<tr>
  <td>Confirm Password</td>
  <td> <input type='password' name='confirm' <input name='password' value='<?php echo showPost("password")?>' /></td>
</tr>
<tr>
  <td>Email</td>
  <td> <input type='text' name='email'<input name='email' value='<?php echo showPost("email")?>' /> </td>
</tr>
<tr>
  <td>First Name</td>
  <td> <input type='text' name='firstname'<input name='firstname' value='<?php echo showPost("firstname")?>'/> </td>
</tr>
<tr>
  <td>Last Name</td>
  <td> <input type='text' name='lastname' <input name='lastname' value='<?php echo showPost("lastname")?>'/> </td>
</tr>

<tr>
  <td colspan='2' style='text-align: center; background-color: white;'> 
    <input type='submit' name='selection' value='Create Account' />
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
