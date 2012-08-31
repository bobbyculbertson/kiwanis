<?php
require_once 'functions.php';
?>

<form method="post" action="clubaccountsummary.php">
	<select name="account" id="account">
		<option value="1">Administrative</option>
		<option value="2">Project</option>
	</select>
	<input type="submit" name="submit" value="Show Summary">
</form>
<table>
	<tr>
	<td>Date</td>
	<td>Amount</td>
	<td>Comments</td>
	</tr>
	
<?php 
if (isset($_POST['account'])) {
	$account = $_POST['account'];
	$results = clubAccountSummary($account);
	while($row = $results->fetch_array()) {
		echo "<tr>";
		echo '<td>'.$row['date'].'</td>';
		echo '<td>'.$row['amount'].'</td>';
		echo '<td>'.$row['comments'].'</td>';
		echo "</tr>";
	}
	$balance = clubAccountBalance($_POST['account']);
	echo "Account Balance: <strong>$balance</strong>";
}
?>
</table>
<?php 

?>