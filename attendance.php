<?php
$title = "Attendance";
require_once 'header.php';
require_once 'class.php';
?>

<h2>Attendance Form</h2>
<form method="post" action="attendance.php">
	<table>
		<tr>
		<td>Date:</td>
		<td><input type="date" name="date"></td>
		</tr>
		<?php 
		$obj = new Members();
		$results = $obj->getCurrentMembers();
		foreach ($results as $result){
			$checkbox = 'checkbox'.$result['id'];
			echo '<tr>';
			echo '<td>'.$result['LastName'].', '.$result['FirstName'].'</td>';
			echo "<td><input type='checkbox' name=$checkbox value='yes'></td>";
			echo '</tr>';
		}
		$obj = null;
		?>
	<tr>
		<td><input type="submit" name="submit" value="Submit Attendance"></td>
		<td><a href="admin.php"><input type="button" value="Cancel"></a>
	</tr>
		<input type="hidden" name="validate">	
	</table>


</form>


<?php 
if(isset($_POST['validate'])){
	if($_POST['date']==''){
		echo 'Please enter a date';
	} else {
		$obj2 = new Visits();
		$count = 0;
		foreach ($results as $test){
			$var = 'checkbox'.$test['id'];
			if($_POST[$var]=='yes'){
				$date = $_POST['date'];
				$memberID = $test['id'];
				$conclusion = $obj2->setVisit($date, $memberID, 1, '');
				$count += 1;
				$conclusion = null;
			}
		}
	} echo "Successfully added $count attendance records";
}

$results = null;
$result = null;
$test = null;
$count = null;
?>