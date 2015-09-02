<?php
require("../../db_creds.inc.php");
$title = "My amazing car table";
include("header.inc.php");
$row_class = "odd";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// inserting new record
if($_SERVER["REQUEST_METHOD"] == "POST"){

	$engine = $_POST["car_engine"];
	$model = $_POST["car_model"];
	$year = $_POST["car_year"];
	$color = $_POST["car_color"];
	$make_id = $_POST["car_make"];
	//don't forget to quote your inserted variables :-(
	$sql_insert = "INSERT INTO vehicles (id, engine, model, year, color, make_id) VALUES (NULL, '$engine', '$model', '$year', '$color', '$make_id')";

	if ($conn->query($sql_insert) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

//delete requested record
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_id"])){
    $delete_id = $_GET["delete_id"];
    $sql_delete = "DELETE FROM vehicles WHERE id = '$delete_id'";
    if($conn->query($sql_delete) === TRUE) {
        echo "Record deleted";
    } else {
        echo "Error on delete:" . $sql_delete . "<br>" .$conn->error;
    }
}

// reading current cars
$sql = "SELECT vehicles.id, vehicles.model, vehicles.year, vehicles.engine, vehicles.color, makers.name FROM vehicles LEFT OUTER JOIN makers ON makers.id = vehicles.make_id";
$result = $conn->query($sql);

// reading makers
$sql_makers = "SELECT * FROM makers";
$result_makers = $conn->query($sql_makers);


echo "<table class='vehicles'>\n";
echo "<tr class='header-row'>\n";
echo "\t<th>Make</th>\n"; // `\t` is tab space
echo "\t\t<th>Model</th>\n";
echo "\t\t<th>Year</th>\n";
echo "\t\t<th>Engine</th>\n";
echo "\t\t<th>Color</th>\n";
// new for delete
echo "\t\t<th>Delete</th>\n";
echo "</tr>\n";

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		echo "<tr class='data-row $row_class'>";
		echo "<td>" . $row["name"] . "</td>";
		echo "<td>" . $row["model"] . "</td>";
		echo "<td>" . $row["year"] . "</td>";
		echo "<td>" . $row["engine"] . "</td>";
		echo "<td>" . $row["color"] . "</td>";
		// <a href="mypage.php?delete_id=2">Delete</a>
		echo "<td><a href=". $_SERVER["PHP_SELF"]. "?delete_id=".$row['id']."> delete</a></td>";
		echo "</tr>";
		if($row_class == "odd"){
			$row_class = "even";
		} else if($row_class == "even") {
			$row_class = "odd";
		}
	}
} else {
	echo "0 results; nope";
}
echo "</table>";

$conn->close();
?>
<div class="input-form">
	<form action="" method="post">
		<label for="newCarModel"> Model:
    		<input type="text" name="car_model" id="newCarModel" />
    	</label>
    	<label for="newCarYear"> Year:
    		<input type="text" name="car_year" id="newCarYear" />
    	</label>
    	<label for="newCarEngine"> Engine:
    		<input type="text" name="car_engine" id="newCarEngine" />
    	</label>
    	<label for="newCarColor"> Color:
    		<input type="text" name="car_color" id="newCarColor" />
    	</label>
    	<label for="newCarMake"> Make:
    	<select name="car_make">
    	<?php
    	    if($result_makers->num_rows > 0){
            	while($maker_row = $result_makers->fetch_assoc()){
            	echo "<option value='".$maker_row["id"]."'>".$maker_row["name"]."</option>";
            	}
            }
    	?>

    	</select>
    	</label>
		<button type="submit">Insert new car</button>

	</form>

</div>
<?php
include("footer.inc.php");
?>