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
    }	
}

function getDBConnection()
{
    $user = "kurban";
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
    $sql = "SELECT * FROM users WHERE deleted_at IS NULL;";
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
           . "<th></th>"    // edit button   
           . "<th></th>"    // delete button   
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
               . "<td>" . $row["email"] . "</td>"   ;
	    echo "<td>";
//	    printEditButton($row["id"]);
	    printEditImage($row["id"]);
	    echo "</td>";
	    echo "<td>";
//	    printDeleteButton($row["id"]);
	    printDeleteImage($row["id"]);
	    echo "</td>";
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

// print an edit button form.
function printEditButton($id)
{
    echo "<form action='modifyAccount.php' method='POST'>";
    echo "<input type='hidden' name='id' value='$id' />";
    echo "<input type='submit' name='selection' value='Edit' />";
    echo "</form>";
}

function printEditImage($id)
{
    echo "<form action='modifyAccount.php' method='POST'>";
    echo "<input type='hidden' name='id' value='$id' />";
    echo "<input type='hidden' name='selection' value='Edit' />";
    echo "<input type='image' height='20' src='library/editicon.gif' />";
    echo "</form>";
}

// print an delete button form.
function printDeleteButton($id)
{
    echo "<form action='deleteAccount.php' method='POST'>";
    echo "<input type='hidden' name='id' value='$id' />";
    echo "<input type='submit' name='selection' value='Delete' />";
    echo "</form>";
}

// print an delete button form with an Image.
function printDeleteImage($id)
{
    echo "<form action='deleteAccount.php' method='POST'>";
    echo "<input type='hidden' name='id' value='$id' />";
    echo "<input type='hidden' name='selection' value='Delete' />";
    echo "<input type='image' height='20' src='library/deleteicon.gif' />";
    echo "</form>";
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
    $sql = "SELECT * FROM users WHERE username=? 
                                AND deleted_at IS NULL;"; // SQL with parameters
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
    $sql = "SELECT * FROM users WHERE id=? 
                                AND deleted_at IS NULL;"; // SQL with parameters
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


function updateUserRecord($conn)
{
    // we've already verified $_POST['id']
    // prepare since there's user input
    $stmt = $conn->prepare("UPDATE users SET email=? 
                                         WHERE id=?"); 
    // bind variable names and types
    $stmt->bind_param("si", $email, $id);
    
    // move the information from the form into 'bound' variables
    $email = $_POST['email'];
    $id    = $_POST['id'];
    
    // put the statement together and send it to the database
    $stmt->execute();
}

function deleteUserRecord($conn)
{
    // we've already verified $_POST['id']
    $stmt = $conn->prepare("UPDATE users SET deleted_at=? 
                                         WHERE id=?"); 
    $stmt->bind_param("si", $time, $id);
    $time  = date("Y-m-d H:i:s");    
    $id    = $_POST['id'];
    $stmt->execute();
}

?>
