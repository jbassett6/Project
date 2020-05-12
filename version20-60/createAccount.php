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
firstname, lastname, address1, address2, city, state, zip) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
	    // bind variable names and types
	    $stmt->bind_param("sssssssssss", $username, $encrypted_password, 
                                  $usergroup, $email, $firstname, $lastname,
$address1, $address2, $city, $state, $zip);

	    $username=$_POST['username'];
	    $encrypted_password=password_hash($_POST['password'], 
                                          PASSWORD_DEFAULT);
	    $usergroup=$_POST['usergroup'];
	    $email=$_POST['email'];
	    $firstname=$_POST['firstname'];
	    $lastname=$_POST['lastname'];
	    $address1=$_POST['address1'];
	    $address2=$_POST['address2'];
	    $city=$_POST['city'];
	    $state=$_POST['state'];
	    $zip=$_POST['zip'];
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
  <td>Address Line 1</td>
  <td> <input type='text' name='address1' <input name='address1' value='<?php echo showPost("address1")?>'/> </td>
</tr>
<tr>
  <td>Address Line 2</td>
  <td> <input type='text' name='address2' <input name='address2' value='<?php echo showPost("address2")?>'/> </td>
</tr>
<tr>
  <td>City</td>
  <td> <input type='text' name='city' <input name='city' value='<?php echo showPost("city")?>'/> </td>
</tr>
<tr>
  <td>State</td>
  <td> <input type='text' name='state' <input name='state' value='<?php echo showPost("state")?>'/> </td>
</tr>
<tr>
  <td>Zipecode</td>
  <td> <input type='text' name='zip' <input name='zip' value='<?php echo showPost("zip")?>'/> </td>
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
