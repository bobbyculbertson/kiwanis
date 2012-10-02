<?php
$title="Add Dues";
require_once 'header.php';
require_once 'class.php';

?>

<h2>Calculate Dues</h2>
<form method="post" action="dues.php">
<table>
	<tr>
		<td>Date Range for Visits in Quarter</td>
	</tr>
	<tr>
		<td>Start Date</td>
		<td><input type="date" name="startDate"></td>
	</tr>
	<tr>
		<td>End Date</td>
		<td><input type="date" name="endDate"></td>
	</tr>
	<tr>
		<td>Quarter Membership Dues</td>
	</tr>
	<tr>
		<td><input type="text" name="dues" value="40.00" size="10"></td>
		<td><input type="text" name="commentsDues" value="Quarterly Membership Dues" size="30"></td>
	</tr>
	<tr>
		<td><input type="text" name="meals" value="27.60" size="10"></td>
		<td><input type="text" name="commentsMeals" value="Quarterly Base Meal Dues" size="30"></td>
	</tr>
	<tr>
		<td><input type="submit" name="submit" value="Submit Dues for Members"></td>
		<td><input type="checkbox" name="checkbox" value="checkDues" />Check Box to confirm Dues Submission</td>
		
		<td><input type="hidden" name="validation"></td>
	</tr>
</table>
</form>


<?php 
if(isset($_POST['validation'])) {
	if (!$_POST['checkbox']=="checkDues") {
		echo "Did not check box to confirm Dues Submission";
	} else {
		if($_POST['startDate']==""||$_POST['endDate']==""){
			echo "Dates Required";
		} else {
			if($_POST['startDate'] > $_POST['endDate']){
				echo "Date Range Not Valid";
			} else {
		
		$dues 			= strip_tags(trim($_POST['dues']));
		$commentsDues	= strip_tags(trim($_POST['commentsDues']));
		$meals 			= strip_tags(trim($_POST['meals']));
		$commentsMeals 	= strip_tags(trim($_POST['commentsMeals']));
		$startDate		= strip_tags(trim($_POST['startDate']));
		$endDate		= strip_tags(trim($_POST['endDate']));
		$MemberObj		= new Members();
		$AccountObj		= new Accounts();
		$results 		= $MemberObj->getCurrentMembers();
		foreach($results as $member){
			$memberID = $member['id'];
			$AccountObj->setDues($memberID, $dues, $commentsDues);
			$AccountObj->setDues($memberID, $meals, $commentsMeals);
			$AccountObj->duesVisits($memberID, $startDate, $endDate); 
			$AccountObj->setGuests($memberID, $startDate, $endDate);
		}
	}
}
	}
}
require_once 'footer.php';
?>

