<?php 
$title = "Attendance";
require_once 'header.php';
?>


<p><a href="admin.php">Back to Admin Section</a></p>
<form method="post" action="attendance.php">
<table>
	<tr>
		<td>Member</td>
		<td>
			<select name="members" id="members2">
				<option selected="selected"></option>
				<?php
				$result = memberComboCurrent();
				while($row = $result->fetch_array())
				{
					echo '<option value="'.$row['id'].'">'.$row['LastName'].', '.$row['FirstName'].'</option>';
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Date</td>
		<td><input type="date" name="dateOfVisit"></td>
	</tr>
	<tr>
		<td>Attenders</td>
		<td><input type="text" name="attendance" value="1"></td>
	</tr>
	<tr>
		<td>Comments</td>
		<td><input type="text" name="comments"></td>
	</tr>
	<tr>
		<td><input type="submit" value="Add Record"></td>
<!-- 		<td><a href="index.php"><input type="button" value="Cancel"></a></td> -->
	</tr>
</table>
</form>
<?php 
if (isset($_POST['dateOfVisit'])) {
	if (($_POST['dateOfVisit']=="") || ($_POST['attendance']=="") || ($_POST['members']=="")){
		echo "Please fill entire form";
	} else {
		$date = $_POST['dateOfVisit'];
		$visit = $_POST['attendance'];
		$memberID = $_POST['members'];
		$comments = $_POST['comments'];
		addVisit($memberID, $date, $visit, $comments);
	}
} 

?>
</body>
</html>













