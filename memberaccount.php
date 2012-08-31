<?php 
$title = "Member Account";
require_once 'header.php';
?>
<p>
<a href="admin.php">Back to Admin Page</a></p>
<form method="post" action="memberaccount.php">
	<table>
		<tr>
			<td>Member</td>
			<td><select name="member" id="member2">
					<option selected="selected"></option>
					<?php 
					$result = memberComboCurrent();
					
					while ($row = $result->fetch_array()){
						echo '<option value="'.$row['id'].'">'.$row['LastName'].', '.$row['FirstName'].'</option>';
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
	if (($_POST['member'])=="" || ($_POST['date']=="") ||($_POST['amount']=="") ||($_POST['type']=="")) {
		echo 'Please fill out entire form';
	} else {
	$memberID = $_POST['member'];
	$date = trim($_POST['date']);
	$type = $_POST['type'];
	$amount = $_POST['amount'];
	$comments = $_POST['comments'];
	if ($type=="credit") {
		$amount = -1*$amount;
	}
	addAmount($memberID, $date, $amount, $comments);
	}
}

?>

</body>
</html>