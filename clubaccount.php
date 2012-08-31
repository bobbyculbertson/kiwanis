<?php 
$title = "Club Account";
require_once 'header.php';
?>
<html>
<body>
<a href="admin.php">Back to Admin Page</a>
<form method="post" action="clubaccount.php">
	<table>
		<tr>
			<td>Date</td>
			<td><input type="date" name="date"></td>
		</tr>
		<tr>
			<td>Account</td>
			<td><select name="account" id="account">
					<option selected="selected"></option>
					<?php 
					$result = accountCombo();
					
					while ($row = $result->fetch_array()){
						echo '<option value="'.$row['id'].'">'.$row['account'].'</option>';
					}
					?>
					
			</select></td>
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
			<td>Project/Category</td>
			<td><select name="category" id="category">
					<option value="0" selected="selected"></option>
					<?php 
					$result = categoryCombo();
					while ($row = $result->fetch_array()){
						echo '<option value="'.$row['id'].'">'.$row['category'].'</option>';
					}
				
					?>
					
			</select></td>
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
<input type="hidden" name="validation">
</form>

<?php 
if (isset($_POST['validation'])){
	if (($_POST['date'])=="" || ($_POST['account']=="") ||($_POST['type']=="") ||($_POST['amount']=="")) {
		echo 'Please fill Date, Account, Type, and Amount';
	} else {
	$account 	= $_POST['account'];
	$date 		= trim($_POST['date']);
	$type 		= $_POST['type'];
	$amount 	= $_POST['amount'];
	$comments	= $_POST['comments'];
	$category	= $_POST['category'];
	if ($type=="debit") {
		$amount = -1*$amount;
	}
	$addResults = addClubAccount($date, $account, $type, $amount, $category, $comments);
	echo $addResults;
	}
}

?>

</body>
</html>