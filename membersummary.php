<?php
//Title variable passed to header to give page a Title
$title = "Account Summary";
require_once 'header.php';
require_once 'class.php';
?>

<?php 
if (isset($_POST['validation-summary'])) {
	$startDate = '1970-01-01';
	$endDate = date("Y-m-d");
	$memberID = strip_tags(trim($_POST['member']));
	$AccountObj = new Accounts();
	$MemberObj = new Members();
	$accountSummary = $AccountObj->getAccountSummary($startDate, $endDate, $memberID);
	$memberDetail = $MemberObj->memberInfo($memberID);
	foreach ($memberDetail as $memberInfo) {
		$firstName=$memberInfo['FirstName'];
		$lastName=$memberInfo['LastName'];
	}
}

?>


<h3>Account Summary</h3>
<h4><?php echo $firstName." ".$lastName?></h4>
<table>
	<tr>
		<td><h3>Total Amount Due</h3></td>
		<td></td>
		<?php 
		$Balance = $AccountObj->getAccountBalance($memberID);
		$totalBalance = $Balance[0]['balance'];
		echo "<td><strong><h3>$$totalBalance</h3></strong></td>";
		?>
	</tr>
</table>
	
<p>Account Summary from: <?php echo "$startDate to $endDate"?></p>

<table>
	<tr>
		<td style="width:120px"><strong>Date</strong></td>
		<td style="width:80px"><strong>Amount</strong></td>
		<td><strong>Comments</strong></td>
	</tr>
	<?php 
		foreach($accountSummary as $rows){
			echo "<tr>";
			echo "<td>".$rows['date']."</td>";
			echo "<td>".$rows['amount']."</td>";
			echo "<td>".$rows['comments']."</td>";
			echo "</tr>";
		}
	?>
</table>
<br>


