<?php
// get credentials
require("../../db_creds.inc.php");

// make connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	echo "connection complete";
}

$sql = "UPDATE vehicles SET model = 'bobby', color = 'mauve' WHERE id = 15";

if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

?>