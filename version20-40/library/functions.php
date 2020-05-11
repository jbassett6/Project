<?php

function checkAccount($zone)
{
    // zone is either 'user' or 'admin', anything else is considered 
    // 'none' or publicly accessible

    /// we start the session in checkAccount to make sure it's called.
    session_start();
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
	   . "<th>FULL NAME</td>"   ;
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
	       . "<td>" . $row["lastname"] . "</td>"  ;
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


?>
