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
if($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST["update_flag"])){

	$engine = filter_var($_POST["car_engine"], FILTER_SANITIZE_STRING);
	$model = filter_var($_POST["car_model"], FILTER_SANITIZE_STRING);
	$year = filter_var($_POST["car_year"],  FILTER_SANITIZE_NUMBER_INT);
	$color = filter_var($_POST["car_color"], FILTER_SANITIZE_STRING);
	$make_id = filter_var($_POST["car_make"], FILTER_SANITIZE_NUMBER_INT);
	//don't forget to quote your inserted variables :-(
	$sql_insert = "INSERT INTO vehicles (id, engine, model, year, color, make_id) VALUES (NULL, '$engine', '$model', '$year', '$color', '$make_id')";

	if ($conn->query($sql_insert) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// updating a record
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_flag"])){
	$engine_update = filter_var($_POST["car_engine"], FILTER_SANITIZE_STRING);
	$model_update = filter_var($_POST["car_model"], FILTER_SANITIZE_STRING);
	$year_update = filter_var($_POST["car_year"],  FILTER_SANITIZE_NUMBER_INT);
	$color_update = filter_var($_POST["car_color"], FILTER_SANITIZE_STRING);
	$make_id_update = filter_var($_POST["car_make"], FILTER_SANITIZE_NUMBER_INT);
	$id_update = $_POST["update_flag"];
	$sql_update = "UPDATE vehicles SET model = '$model_update', 
					engine = '$engine_update',
					year = '$year_update',
					color = '$color_update',
					make_id = '$make_id_update' WHERE id = $id_update";
	if ($conn->query($sql_update) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
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
echo "\t\t<th>Action</th>\n";
echo "</tr>\n";

if($result->num_rows > 0){
	// if we're in update mode and this is the update row, let's make a form

	while($row = $result->fetch_assoc()){
		// check to see if the $_GET array has 'update_id' in it
		// if it does, let's make this row into a mini-form
		if(isset($_GET["update_id"]) && $_GET["update_id"] == $row['id']){
			?>
			<tr class="data-row update">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			<input type="hidden" name="update_flag" value="<?php echo $row['id']; ?>">
			<td><select name="car_make">
    	<?php
    	    if($result_makers->num_rows > 0){
            	while($maker_row = $result_makers->fetch_assoc()){
            	echo "<option value='".$maker_row["id"]."'>".$maker_row["name"]."</option>";
            	}
            }
    	?>

    	</select></td>
			<td><input name="car_model" value="<?php echo $row["model"]  ?>"></td>
			<td><input name="car_year" value="<?php echo $row["year"]  ?>"></td>
			<td><input name="car_engine" value="<?php echo $row["engine"]  ?>"></td>
			<td><input name="car_color" value="<?php echo $row["color"]  ?>"></td>
			<td><button type="submit"> Update row </button></td>
			</form>
			</tr>
			<?php
		} else {
			echo "<tr class='data-row $row_class'>";
			echo "<td>" . $row["name"] . "</td>";
			echo "<td>" . $row["model"] . "</td>";
			echo "<td>" . $row["year"] . "</td>";
			echo "<td>" . $row["engine"] . "</td>";
			echo "<td>" . $row["color"] . "</td>";
			echo "<td>"
				 ."	<a href=". $_SERVER["PHP_SELF"] . "?delete_id=" . $row['id'] . "> delete</a> |"  // for delete
				 ." <a href=". $_SERVER["PHP_SELF"] . "?update_id=" . $row['id'] . "> update</a>"	// for update
				 ."</td>";
			echo "</tr>";
			if($row_class == "odd"){
				$row_class = "even";
			} else if($row_class == "even") {
				$row_class = "odd";
			}
		}
	}
} else {
	echo "0 results; nope";
}
echo "</table>";

$conn->close();
?>
<div class="input-form">
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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