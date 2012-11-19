<?php
//Title variable passed to header to give page a Title
$title = "Delete Records";
require_once 'header.php';
require_once 'class.php';
?>

<form method="post" action="delete.php">
	<table>
		<tr>
			<td>Delete Records From: </td>
			<td><select name="delete">
					<option selected="selected"></option>
					<option value="visits">Visits</option>
					<option value="guests">Guests</option>
					<option value="account">Member Account Records</option>
				</select></td>
		</tr>
		<tr>
			<td>Date Range</td>
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
			<td><input type="submit" name="submit" value="Find Records"></td>
		</tr>
		<input type="hidden" name="validation">
	</table>
</form>

<?php 
  if(isset($_POST['validation'])) {
	
	$startDate = strip_tags(trim($_POST['startDate']));
	$endDate = strip_tags(trim($_POST['endDate']));
	//Checks to see if Dates have been entered
	if($startDate= "" || $endDate= "") {
		echo "Please fill out both Date Ranges";
	} 
	 else {
		if($_POST['startDate']>$_POST['endDate']){
			echo 'Your date range is invalid';
		} switch ($_POST['delete']) {
			case visits:  
				visitsRecords($_POST['startDate'], $_POST['endDate']);  
				break;
			case guests:
				guestsRecords($_POST['startDate'], $_POST['endDate']);
				break;
			case account:
				accountRecords($_POST['startDate'], $_POST['endDate']);
				break;
			}
	}  
}   
//Delete Visit Record Section 
function visitsRecords($startDate, $endDate) {
	//Displays Visit Records for Date Range
	$VisitObj = new Visits();
	$allVisits = $VisitObj->getVisits($startDate, $endDate);
	echo "<table>";
	echo "<tr>";
	echo "<td>Record ID</td><td>Date</td><td>First Name</td><td>Last Name</td>";
	echo "</tr>";
	foreach($allVisits as $Visits) {
		echo "<tr>";
		echo "<td>".$Visits['id']."</td>";
		echo "<td>".$Visits['date']."</td>";
		echo "<td>".$Visits['FirstName']."</td>";
		echo "<td>".$Visits['LastName']."</td>";
		echo "<td><a href='?visit_delete_id=".$Visits['id']."'>Delete</a></td>";
		echo "</tr>";
	}
	echo "</table>";
	$VisitObj = null;
}
//Code follows Delete Link Clicked
 if(isset($_GET[visit_delete_id])) { 
	$visitDeleteID =$_GET[visit_delete_id];
	echo "Are you sure you want to delete this record?";
	echo "<form method='post' action='delete.php'>";
	echo "<table>";
	$VisitObj = new Visits();
	$selectVisits = $VisitObj->selectVisits($visitDeleteID);
	foreach($selectVisits as $selectVisit) {
		echo "<tr>";
		echo "<td>".$selectVisit['date']."</td><td>".$selectVisit['FirstName']." </td><td>".$selectVisit['LastName']."</td>";
		echo "<input type='hidden' name='id_delete' value='".$selectVisit['id']."'>";
		echo "</tr>";
	}
	echo "<tr><td><input type='submit' name='yes' value='Yes'></td>";
	echo "<td><a href='delete.php'><input type='button' value='No'></a></td></tr>";
	echo "<input type='hidden' name='validation_visit'>";
	echo "</table>";
	echo "</form>";
	$VisitObj = null;
  } 
//Code Follow 'Yes' Clicked
if(isset($_POST['validation_visit'])) {
	$visitDeleteID = $_POST['id_delete'];
	$VisitObj = new Visits();
	$deleteVisit = $VisitObj->deleteVisits($visitDeleteID);
	echo $deleteVisit;
	$VisitObj = null;
}

//Delete Guest Record Section
function guestsRecords($startDate, $endDate) {
	//Displays Guest Records for Date Range
	$GuestObj = new Guests();
	$allGuests = $GuestObj->getGuests($startDate, $endDate);
	echo "<table>";
	echo "<tr>";
	echo "<td>Record ID</td><td>Date</td><td>Type ID</td><td>Comments</td>";
	echo "</tr>";
	foreach($allGuests as $Guests) {
		echo "<tr>";
		echo "<td>".$Guests['id']."</td>";
		echo "<td>".$Guests['date']."</td>";
		echo "<td>".$Guests['type']."</td>";
		echo "<td>".$Guests['comments']."</td>";
		echo "<td><a href='?guest_delete_id=".$Guests['id']."'>Delete</a></td>";
		echo "</tr>";
	}
	echo "</table>";
	$GuestObj = null;
}

//Code follows Delete Link Clicked
if(isset($_GET[guest_delete_id])) {
	$guestDeleteID =$_GET[guest_delete_id];
	echo "Are you sure you want to delete this record?";
	echo "<form method='post' action='delete.php'>";
	echo "<table>";
	$GuestObj = new Guests();;
	$selectGuests = $GuestObj->selectGuests($guestDeleteID);
	foreach($selectGuests as $selectGuest) {
		echo "<tr>";
		echo "<td>".$selectGuest['date']."</td><td>".$selectGuest['type']." </td><td>".$selectGuest['comments']."</td>";
		echo "<input type='hidden' name='id_delete' value='".$selectGuest['id']."'>";
		echo "</tr>";
	}
	echo "<tr><td><input type='submit' name='yes' value='Yes'></td>";
	echo "<td><a href='delete.php'><input type='button' value='No'></a></td></tr>";
	echo "<input type='hidden' name='validation_guest'>";
	echo "</table>";
	echo "</form>";
	$GuestObj = null;
}
//Code Follow 'Yes' Clicked
if(isset($_POST['validation_guest'])) {
	$guestDeleteID = $_POST['id_delete'];
	$GuestObj = new Guests();
	$deleteGuest = $GuestObj->deleteGuest($guestDeleteID);
	echo $deleteGuest;
	$GuestObj = null;
}




//Delete Account Record Section
function accountRecords($startDate, $endDate) {
	//Displays Member Account Records for Date Range
	$AccountObj = new Accounts();
	$allAccounts = $AccountObj->getAccounts($startDate, $endDate);
	echo "<table>";
	echo "<tr>";
	echo "<td>Record ID</td><td>First Name</td><td>Last Name</td><td>Date</td><td>Amount</td><td>Comments</td>";
	echo "</tr>";
	foreach($allAccounts as $Accounts) {
		echo "<tr>";
		echo "<td>".$Accounts['id']."</td>";
		echo "<td>".$Accounts['FirstName']."</td>";
		echo "<td>".$Accounts['LastName']."</td>";
		echo "<td>".$Accounts['date']."</td>";
		echo "<td>".$Accounts['amount']."</td>";
		echo "<td>".$Accounts['comments']."</td>";
		echo "<td><a href='?Account_delete_id=".$Accounts['id']."'>Delete</a></td>";
		echo "</tr>";
	}
	echo "</table>";
	$AccountObj = null;
}

//Code follows Delete Link Clicked
if(isset($_GET[Account_delete_id])) {
	$AccountDeleteID =$_GET[Account_delete_id];
	echo "Are you sure you want to delete this record?";
	echo "<form method='post' action='delete.php'>";
	echo "<table>";
	$AccountObj = new Accounts();;
	$selectAccounts = $AccountObj->selectAccounts($AccountDeleteID);
	foreach($selectAccounts as $selectAccount) {
		echo "<tr>";
		echo "<td>".$selectAccount['FirstName']." ".$selectAccount['LastName']."</td></tr><tr><td>".$selectAccount['date']."</td></tr><tr><td>".$selectAccount['amount']." </td></tr><tr><td>".$selectAccount['comments']."</td>";
		echo "<input type='hidden' name='id_delete' value='".$selectAccount['id']."'>";
		echo "</tr>";
	}
	echo "<tr><td><input type='submit' name='yes' value='Yes'></td>";
	echo "<td><a href='delete.php'><input type='button' value='No'></a></td></tr>";
	echo "<input type='hidden' name='validation_Account'>";
	echo "</table>";
	echo "</form>";
	$AccountObj = null;
}
//Code Follow 'Yes' Clicked
if(isset($_POST['validation_Account'])) {
	$AccountDeleteID = $_POST['id_delete'];
	$AccountObj = new Accounts();
	$deleteAccount = $AccountObj->deleteAccount($AccountDeleteID);
	echo $deleteAccount;
	$AccountObj = null;

}



?>
