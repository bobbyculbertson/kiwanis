<?php
//Title variable passed to header to give page a Title
$title = "Guests";
require_once 'header.php';
require_once 'class.php';
?>
<h2>Guest Form</h2>
<form method="post" action="guests.php">
	<table>
		<tr>
			<td>Date</td>
			<td><input type="date" name="date"></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><select name="type" id="type">
					<option selected="selected"></option>
					<?php 
					$obj2 = new Guests();
					$stuff = $obj2->getGuestType();
					foreach($stuff as $things){
						echo '<option value="'.$things['id'].'">'.$things['type'].'</option>';
					}
					?>
			</select></td>
		</tr>
		<tr>
			<td>If Member's Guest, member to bill</td>
			<td><select name="memberBill" id="memberBill">
					<option selected="selected"></option>
					<?php 
					$obj = new Members();
					$results = $obj->getCurrentMembers();
					foreach($results as $result){
						echo '<option value="'.$result['id'].'">'.$result['LastName'].', '.$result['FirstName'].'</option>';
					}
					?>
				</select></td>
		</tr>
		<tr>
			<td>Comments</td>
			<td><input type="textarea" name="comments"></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Add Guest"></td>
			<td><a href="admin.php"><input type="button" value="Cancel"></a></td>
		</tr>
	</table>
</form>

<?php 
//Requires that Date and Type are selected
if(isset($_POST['date']) && isset($_POST['type'])){
	//Validates that if Guest of Member is selected, 
	//that a Member to Bill is also selected
	if($_POST['type']==1 && !$_POST['memberBill']){
		echo "Please Select a Member to Bill";
	} else {
		//Sets variables
		$date = $_POST['date'];
		$type = $_POST['type'];
		if(!$_POST['memberBill']){
			$memberToBill = 0;
		} else {
			$memberToBill = $_POST['memberBill'];
		}
		if(!$_POST['comments']){
			$comments = 0;
		} else {
			$comments = $_POST['comments'];
		}
		$conclusion = $obj2->setGuests($date, $type, $memberToBill, $comments);	
		if(!$conclusion){
			echo 'Error. Please Try again.';
		} else {
			echo 'Success'; 
		}
	}
} 
$obj=null;
$results=null;
$result = null;
$obj2=null;
$conclusion = null;
$stuff=null;
$things=null;
?>