<?php

function checkAccount($zone)
{
    // zone is either 'user' or 'admin', anything else is considered 
    // 'none' or publicly accessible

    /// we start the session in checkAccount to make sure it's called.
    session_start();
    if ($zone == 'user')
    {
	if (!isset($_SESSION['username']))
	{
	    header('Location: welcome.php');
	}
    }	
    if ($zone == 'admin')
    {
	if (!isset($_SESSION['username']))
	{
	    header('Location: welcome.php');
	}
	if ($_SESSION['usergroup'] != 'admin')
	{
	    header('Location: welcome.php');
	}
    if ($zone == 'superuser')
    {
        if (!isset($_SESSION['username']))
        {
            header('Location: suhome.php');
        }
        if ($_SESSION['usergroup'] != 'superuser')
        {
            header('Location: suhome.php');
        }
    }

    }	
}

function getDBConnection()
{
    $user = "jbassett6";
    $conn = mysqli_connect("localhost",$user,$user,$user);

    // Check connection and shutdown if broken
    if (mysqli_connect_errno()) {
	die("<b>Failed to connect to MySQL: " . mysqli_connect_error() . "</b>");
    }

    return $conn;
}

function printUserTable($conn)
{
    // build the SQL that pulls the data from the database
    $sql = "SELECT * FROM users;";
    $result = $conn->query($sql);

    echo "<table id='usershow'>";    
    if ($result->num_rows > 0) 
    {
	// column headers
	echo "<tr>";
        echo "<th>ID</th>" 
           . "<th>USERNAME</th>" 
           . "<th>ENCRYPTED PASSWORD</th>" 
           . "<th>GROUP</th>" 
           . "<th>EMAIL</th>"
	   . "<th>FULL NAME</th>"
	   . "<th>Address</td>"         
           . "<th></th>"    // edit button   
	   ;
	echo "</tr>";

	// loop through all the rows 
	while( $row = $result->fetch_assoc() ) 
	{
	    // output the data from each row
	    echo "<tr>";
	    echo "<td>" . $row["id"] . "</td>" 
               . "<td>" . $row["username"] . "</td>" 
               . "<td>" . $row["encrypted_password"] . "</td>" 
               . "<td>" . $row["usergroup"] . "</td>" 
               . "<td>" . $row["email"] . "</td>"   
	       . "<td>" . $row["firstname"] . "</td>"
	       . "<td>" . $row["lastname"] . "</td>"   
	       . "<td>" . $row["address1"] . "<br>" 
			. $row["address2"] . "<br>"
			.  $row["city"] . ", ". $row["state"] .", ". $row["zip"] .", ". "</td>" ;
	    printEditButton($row["id"]);
	    echo "</tr>";
	}
    } 
    else 
    {
	// empty table
	echo "<tr><td>0 results</td></tr>";
    }
    echo "</table>";
}

// print an edit button in a <td>
function printEditButton($id)
{
    echo "<td>";
    echo "<form action='modifyAccount.php' method='POST'>";
    echo "<input type='text' name='id' value='$id' />";
    echo "<input type='submit' name='selection' value='Edit' />";
    echo "</form>";
    echo "</td>";
}

function displayError($mesg)
{
    echo "<div id='errorMessage'>";
    echo $mesg;
    echo "</div>";
}

function showPost( $name )
{
# check to see if it been used, if it has, return it
    if ( isset($_POST[$name]) ) 
    {
        return $_POST[$name];
    }
    return "";
}

function lookUpUserName($conn, $usernameToFind)
{
    $sql = "SELECT * FROM users WHERE username=? ;"; // SQL with parameters
    #    echo "<code>$sql</code>";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $usernameToFind);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    if ($result->num_rows == 1) 
    {
	return $result;
    }
    else
    {
	return FALSE;
    }
}

// get the record for a user by id
function lookUpUserNameByID($conn, $idToFind)
{
    $sql = "SELECT * FROM users WHERE id=? ;"; // SQL with parameters
    #    echo "<code>$sql</code>";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("i", $idToFind);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    if ($result->num_rows == 1) 
    {
	return $result;
    }
    else
    {
	return FALSE;
    }
}

function checkAndStoreLogin( $conn, $usernameToTest, $passwordToTest )
{
    // setting $_SESSION['username'] and $_SESSION['usergroup']

    $result=lookupUserName($conn, $usernameToTest);
    if ($result != FALSE)
    {
	$row = $result->fetch_assoc();
	$encrpytedFromDB = $row['encrypted_password'];
	if ( password_verify($passwordToTest, $encrpytedFromDB) )
	{
	    $_SESSION['username'] = $row['username'];
	    $_SESSION['usergroup'] = $row['usergroup'];
	    return TRUE;
	}
    }
    return FALSE;
}


?>
