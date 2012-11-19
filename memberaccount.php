<?php 
//Title variable passed to header to give page a Title
$title = "Member Account";
require_once 'header.php';
require_once 'class.php';
?>
<h2>Member Account Records</h2>
<form method="post" action="memberaccount.php">
	<table>
		<tr>
			<td>Member</td>
			<td><select name="member" id="member2">
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
			<td>Date</td>
			<td><input type="date" name="date"></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><select name="type" id="type2">
				<option selected="selected"></option>
				<option value="credit">Credit</option>
				<option value="debit">Debit</option>
				</select>
			</td>
		</tr>

		<tr>
			<td>Amount</td>
			<td><input type="text" name="amount"></td>
		</tr>
		<tr>
			<td>Comments</td>
			<td><textarea rows="3" name="comments"></textarea></td>
		</tr>
		<tr>
			<td><input type="submit" name="add" value="Add Record"></td>
			<td><a href="admin.php"><input type="button" value="Cancel"></a></td>
		</tr>
	</table>

</form>

<?php 
if (isset($_POST['date'])){
	//Validates that entire form is filled out
	if (($_POST['member'])=="" || ($_POST['date']=="") ||($_POST['amount']=="") ||($_POST['type']=="")) {
		echo 'Please fill out entire form';
	} else {
		//Sets variables
		$memberID = $_POST['member'];
		$date = $_POST['date'];
		$type = $_POST['type'];
		$amount = strip_tags(trim($_POST['amount']));
		$comments = strip_tags(trim($_POST['comments']));
		//Test to confirm Amount is a number
		if(!is_numeric($amount)){
			echo "Please enter a valid number for amount";
		} else {
			//If amount is a credit, changes it to a negative number to subtract
			//from running total
			if ($type=="credit") {
				$amount = -1*$amount;
			}
			$AccountsObj = new Accounts();
			$conclusion = $AccountsObj->setAmount($date, $memberID, $amount, $comments);
			if(!$conclusion){
				echo 'Error. Please Try Again';
			} else {
				echo 'Record Added Successfully';
			}
		}
	}
}
$memberID = null;
$date = null;
$type = null;
$amount = null;
$comments = null;
$AccountsObj = null;
$conclusion = null;
?>

</body>
</html>