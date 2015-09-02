<?php
require("../../db_creds.inc.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br>";
$sql = "SELECT * FROM vehicles LEFT OUTER JOIN makers ON makers.id = vehicles.make_id";

$result = $conn->query($sql);


if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		echo "id: " . $row['id'] . " year: " . $row["year"] . " make: " . $row["name"] . " model: " . $row["model"] . "<br>";
	}
} else {
	echo "0 results; nope";
}

$conn->close();
?>