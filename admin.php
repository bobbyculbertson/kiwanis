<?php
$title="Admin Page";
require_once 'header.php';

?>


<form method="post" action="admin.php">
<table>
	<tr>
		<td>Start Date</td>
		<td><input type="date" name="startDate"></td>
	</tr>
	<tr>
		<td>End Date</td>
		<td><input type="date" name="endDate"></td>
	</tr>
		<tr>
		<td><input type="text" name="dues" value="25.00" size="10"></td>
		<td><input type="text" name="commentsDues" value="Quarterly Membership Dues" size="30"></td>
	</tr>
	<tr>
		<td><input type="text" name="meals" value="55.20" size="10"></td>
		<td><input type="text" name="commentsMeals" value="Quarterly Base Meal Dues" size="30"></td>
	</tr>
	<tr>
		<td><input type="submit" name="submit" value="Attendance Summary"></td>
		<td><input type="submit" name="submit" value="Submit Dues for Members"><input type="checkbox" name="checkbox" value="checkDues" />Check Box to confirm Dues Submission</td>
		
		<td><input type="hidden" name="validation"></td>
	</tr>
</table>
</form>
Create Bill
<form method="post" action="bill.php">
	<table>
		<tr>
			<td>Range for Account Summary</td>
		</tr>
		<tr>
			<td>Start Date</td>
			<td><input type="date" name="startDate" value="<?php echo $startDate;?>"></td>
		</tr>
		<tr>
			<td>End Date</td>
			<td><input type="date" name="endDate"></td>
		</tr>
		<tr>
			<td>Choose Member</td>
			<td><select name="member" id="member2">
					<option selected="selected"></option>
					<?php 
					$results = memberComboCurrent();
					while ($row = $results->fetch_array()) {
					echo '<option value="'.$row['id'].'">'.$row['LastName'].', '.$row['FirstName'].'</option>';
				}
				?>
			</select></td>
		</tr>
		<tr>
			<td><input type="hidden" name="validation"><input type="submit" name="choice" value="Create Bill"></td>
		</tr>
		
	</table>
	
</form>

<?php 
if(isset($_POST['validation'])) {
	switch ($_POST['submit']) {
		case "Submit Dues for Members":
			if ($_POST['checkbox']=="checkDues") {
				$dues 			= trim($_POST['dues']);
				$commentsDues	= trim($_POST['commentsDues']);
				$meals 			= trim($_POST['meals']);
				$commentsMeals 	= trim($_POST['commentsMeals']);
				$startDate		= trim($_POST['startDate']);
				$endDate		= trim($_POST['endDate']);
				$members		= memberComboCurrent();
				while ($row = $members->fetch_array()){
					$memberID = $row['id'];
					dues($memberID, $dues, $commentsDues);
					meals($memberID, $meals, $commentsMeals);
					duesVisits($memberID, $startDate, $endDate);
					}
				break;
			} else {
				echo "Did not check box to confirm Dues Submission";
				break;
			}
		case "Attendance Summary":
			$startDate		= trim($_POST['startDate']);
			$endDate		= trim($_POST['endDate']);
			sumVisits($startDate, $endDate);
			break;
	}
}
require_once 'footer.php';
?>

