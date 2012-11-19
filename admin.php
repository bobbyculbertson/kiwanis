<?php
//Title variable passed to header to give page a Title
$title="Admin Page";
require_once 'header.php';
require_once 'class.php';
//Builds object from Dues class
$DuesObj = new Dues();
$variables = $DuesObj->getVariables();
?>

<h2>Administrator Section</h2>
<form method="post" action="admin.php">
	<h3>Set Dues Variables</h3>
	<table>
		<tr>
			<td>Quarterly Membership Dues</td>
			<td><input type="text" name="dues"
				value="<?php echo $variables['membership'];?>" size="10"></td>
		</tr>
		<tr>
			<td>Price Per Meal</td>
			<td><input type="text" name="meals"
				value="<?php echo $variables['price'];?>" size="10"></td>
		</tr>
		<tr>
			<td>Minimum Meals Per Quarter</td>
			<td><input type="text" name="quarter"
				value="<?php echo $variables['quarter'];?>" size="10"></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Submit Changes"></td>
			<td><a href="admin.php"><input type="button" value="Cancel"> </a></td>

			<td><input type="hidden" name="validation"></td>
		</tr>
	</table>
</form>
<form method="post" action="membersummary.php">
	<h3>Create Account Summary</h3>
	<table>
		<tr>
			<td><select name="member">
					<option selected="selected"></option>
					<?php 
					$obj = new Members();
					$results = $obj->getCurrentMembers();
					foreach($results as $result){
						echo '<option value="'.$result['id'].'">'.$result['LastName'].', '.$result['FirstName'].'</option>';
					}
					?>
			</select></td>
			<td><input type="submit" name="submit-summary" value="Account Summary"></td>
			<input type="hidden" name="validation-summary">
		</tr>
	</table>
</form>
<form method="post" action="admin.php">
	<table>
		<tr>
			<td><h3>Create Attendance Summary</h3></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>Start Date</td>
			<td><input type="date" name="startDate"></td>
		</tr>
		<tr>
			<td>End Date</td>
			<td><input type="date" name="endDate"></td>
			<td><input type="submit" name="submit-attendance" value="Attendance Summary"><input type="submit" name="submit-guest" value="Guest Summary">
			<input type="submit" name="submit-distinct" value="Dates Recorded"><input type="submit" name="submit-allBalance" value="All Member's Balances"></td>
		</tr>
	</table>
</form>
<?php 
if(isset($_POST['validation'])){
	//Validates all entries are numbers
	if(!is_numeric($_POST['dues']) || !is_numeric($_POST['meals']) || !is_numeric($_POST['quarter'])){
		echo 'All fields need to be a number';
	} 
	//Sets variables to be passed to query
	$membershipDues = strip_tags(trim($_POST['dues']));
	$pricePerMeal	= strip_tags(trim($_POST['meals']));
	$mealsInQuarter = strip_tags(trim($_POST['quarter']));
	//Passes variables to set the Price Per Meal. 1 indicateds the id number in the variable table
	$resultsMeal 	= $DuesObj->setVariables($pricePerMeal, 1);
	//Passes variables to set the Minimum meals in a quarter. 2 indicateds the id number in the variable table
	$resultsQuarter	= $DuesObj->setVariables($mealsInQuarter, 2);
	//Passes variables to set the Membership Dues. 3 indicateds the id number in the variable table
	$resultsMember	= $DuesObj->setVariables($membershipDues, 3);
	//Reloads the page so you can see the current values after you submit new values
	$membershipDues = null;
	$pricePerMeal 	= null;
	$mealsInQuarter = null;
	$resultsMeal 	= null;
	$resultsQuarter = null;
	$resultsMember 	= null;
	header('Location: admin.php');
}
//Creates Summary of Attendance based on Start and End Dates
if(isset($_POST['submit-attendance'])){
 	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate']; 
	$VisitObj = new Visits();
	$VisitResults = $VisitObj->getSumVisits($startDate, $endDate);
	$visitCount = 0;
	foreach($VisitResults as $visitResult){
		echo $visitResult['QtrVisits']." ".$visitResult['FirstName']." ".$visitResult['LastName']."<br>";
		$visitCount += $visitResult['QtrVisits'];
	}
	echo "<h4>Total Visits in Range: $visitCount</h4>";
} 
//Creates Summary of Guests based on Start and End Dates
if(isset($_POST['submit-guest'])){
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	$GuestObj = new Guests();
	$GuestResults = $GuestObj->getGuests($startDate, $endDate);
	$guestCount=0;
	foreach($GuestResults as $guestResult){
		echo $guestResult['date']." ".$guestResult['type']." ".$guestResult['comments']."<br>";
		$guestCount +=1;
	}
	echo "<h4>Total Guests in Date Range: $guestCount</h4>";
}

if(isset($_POST['submit-distinct'])){
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	$VisitObj = new Visits();
	$VisitResults = $VisitObj->distinctVisits($startDate, $endDate);
	foreach($VisitResults as $visitResult){
		echo $visitResult['date']."<br>"; 
	}
}

if(isset($_POST['submit-allBalance'])) {
	$AccountsObj = new Accounts();
	$BalanceResults = $AccountsObj->getAllAccountBalance();
	echo "<table border='1'><tr style='font-weight:bold;'><td>First Name</td><td>Last Name</td><td>Balance</td></tr>";
	foreach($BalanceResults as $balanceResult) {
		echo "<tr><td>".$balanceResult['FirstName']."</td><td>".$balanceResult['LastName']."</td><td>".$balanceResult['balance']."</td></tr>";
}	echo "</table>";

}
?>
