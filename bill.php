<?php
require_once 'functions.php';
?>

<?php 
if (isset($_POST['validation'])) {
	$startDate = trim($_POST['startDate']);
	$endDate = trim($_POST['endDate']);
	$memberID = trim($_POST['member']);
	
	$accountSummary = accountSummary($startDate, $endDate, $memberID);
	$memberDetail = memberInfo($memberID);
	$memberInfo = $memberDetail->fetch_array();
	$firstName=$memberInfo['FirstName'];
	$lastName=$memberInfo['LastName'];
	
	}

?>


<h2>Morris Kiwanis Member Bill</h2>
<h4><?php echo $firstName." ".$lastName?></h4>
<h5>Invoice Date: <?php echo date("m.d.y");?></h5>
	

<br><br><br>
<p>Account Summary from: <?php echo "$startDate to $endDate"?></p>
<table>
	<tr>
		<td style="width:120px"><strong>Date</strong></td>
		<td style="width:80px"><strong>Amount</strong></td>
		<td><strong>Comments</strong></td>
	</tr>
	<?php 
		while ($rows=$accountSummary->fetch_array()){
			echo "<tr>";
			echo "<td>".$rows['date']."</td>";
			echo "<td>".$rows['amount']."</td>";
			echo "<td>".$rows['comments']."</td>";
			echo "</tr>";
		}
	?>

</table>
<br><br>
<table>
	<tr>
		<td>Total Amount Due</td>
		<td></td>
		<?php 
		$totalBalance = accountBalance($memberID);
		echo "<td><strong>$$totalBalance</strong></td>";
		?>
	</tr>
</table>

<br>
<p>Please make checks payable to:</p>
<p>Morris Kiwanis<br>P.O. Box 173<br>Morris MN 56267</p>
