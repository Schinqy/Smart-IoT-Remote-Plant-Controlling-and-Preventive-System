<?php

    // Connect to the database
    include("connection.php");
$_POST = json_decode(file_get_contents('php://input'), true);
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = test_input($_POST["username"]);
$password= test_input($_POST["password"]);

//$username = "admin";
//$password = "1234";   

    // Prepare the query
    $stmt = mysqli_prepare($conn, "SELECT * FROM login WHERE username= '" . $username . "' AND pwd='" . $password . "' ");
    
  //  mysqli_stmt_bind_param($stmt, "ss", $username, $password);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Check if a row was returned
    if (mysqli_stmt_fetch($stmt)) {
        echo "true";
    } else {
        echo "false";
    }

}

$conn->close();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



?>