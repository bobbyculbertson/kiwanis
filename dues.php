<?php
//Title variable passed to header to give page a Title
$title="Add Dues";
require_once 'header.php';
require_once 'class.php';
//Create object from Dues Class
$DuesObj = new Dues();
$variables = $DuesObj->getVariables();
?>
<h2>Calculate Dues</h2>
<form method="post" action="dues.php">
<table>
	<tr>
		<td>Select Quarter</td>
	</tr>
	<tr>
		<td>Quarter</td>
		<td><select name="quarter" id="quarter">
			<option selected="selected"></option>
			<option value="1">1st Quater</option>
			<option value="2">2nd Quater</option>
			<option value="3">3rd Quater</option>
			<option value="4">4th Quater</option>
		</select>
		
		</td>
	</tr>
	<tr>
		<td>Year</td>
		<td><input type="text" readonly="readonly" name="year" value="<?php $year = date("Y"); echo $year;?>"></td>
	</tr>
</table>
<table>
	<tr>
		<td>Note: If values are not acurate, go to the admin section to change</td>
	</tr>
</table>
<table>
	<tr>
		<td><input type="text" name="dues" readonly="readonly" value="<?php echo $variables['membership'];?>" size="10"></td>
		<td><input type="text" name="commentsDues" value="Quarterly Membership Dues" size="30"></td>
	</tr>
	<tr>
		<td><input type="text" name="meals" readonly="readonly" value="<?php $baseMeal = $variables['price']*$variables['quarter']; echo $baseMeal;?>" size="10"></td>
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
	//Confirms checkbox is checked
	if (!$_POST['checkbox']=="checkDues") {
		echo "Did not check box to confirm Dues Submission";
	} else {
		//Checks that a quarter was selected
		if($_POST['quarter']==""){
			echo 'Please choose a quarter';
		} else {
			//Sets the start and end date variables based on what quarter is selected
			switch ($_POST['quarter']) {
				case 1:
					$startDate = "$year-01-01";
					$endDate = "$year-03-31";
					break;
				case 2:
					$startDate = "$year-04-01";
					$endDate = "$year-06-30";
					break;	
				case 3:
					$startDate = "$year-07-01";
					$endDate = "$year-09-30";
					break;
				case 4:
					$startDate = "$year-10-01";
					$endDate = "$year-12-31";
					break;
			}
			//Create objects based on Dues, Members, and Account classes
			$DuesObj = new Dues();
			$MemberObj		= new Members();
			$AccountObj		= new Accounts();
			//Gets admin variables (membership dues, price per meal, minimum meals per quarter)
			$duesResult		= $DuesObj->getVariables();
			//Membership Dues
			$dues 			= $duesResult['membership'];
			//Calculate Base Meal Price
			$meals 			= $duesResult['price']*$duesResult['quarter'];
			$commentsMeals 	= strip_tags(trim($_POST['commentsMeals']));	
			$commentsDues	= strip_tags(trim($_POST['commentsDues']));
			//Gets every current member
			$results 		= $MemberObj->getCurrentMembers();
			//Cycles through each current member
			foreach($results as $member){
				$memberID = $member['id'];
				//Adds membership dues
				$AccountObj->setDues($memberID, $dues, $commentsDues);
				//Add base meal dues
				$AccountObj->setDues($memberID, $meals, $commentsMeals);
				//Sends variables to calculate if meals in quarter is over the minmum
				$AccountObj->duesVisits($memberID, $startDate, $endDate);
				//Sends variables to calculate if member had guests
				$AccountObj->setGuests($memberID, $startDate, $endDate);
			}
		}
	}
}
$DuesObj 		= null;
$MemberObj 		= null;
$AccountObj 	= null;
$duesResult 	= null;
$dues 			= null;
$meals 			= null;
$commentsDues 	= null;
$commentsMeals 	= null;
$results 		= null;
$memberID 		= null;
require_once 'footer.php';
?>

