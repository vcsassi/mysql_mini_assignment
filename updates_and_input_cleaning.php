<?php
// filtering
$badString = "This has <script src='bad.js'></script> stuff";
$goodString = filter_var($badString,  FILTER_SANITIZE_STRING);
echo $goodString;
echo "<br>";

$badNumber = "This has 10 numbers";
$goodNumber = filter_var($badNumber, FILTER_SANITIZE_NUMBER_INT);
echo $goodNumber;
echo "<br>";
// sanitze filter reference http://uk3.php.net/manual/en/filter.filters.sanitize.php
// validate filter reference http://uk3.php.net/manual/en/filter.filters.validate.php


// updating a record
$sql = "UPDATE dbname SET column_name = 'new value' WHERE id = record_id";
// or 
$sql = "UPDATE dbname SET column1 = 'this', column2 = 'that' WHERE id = record_id";

//application of update
/*if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_flag"])){
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

			//old row stuff except
			echo "<td>"
				 ."	<a href=". $_SERVER["PHP_SELF"] . "?delete_id=" . $row['id'] . "> delete</a> |"  // for delete
				 ." <a href=". $_SERVER["PHP_SELF"] . "?update_id=" . $row['id'] . "> update</a>"	// for update
				 ."</td>";

			 // to handle the update 

		}
*/
		

?>