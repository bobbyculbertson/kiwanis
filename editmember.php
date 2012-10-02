<?php 
$title = "Edit Member";
require_once 'header.php';
require_once 'class.php';
?>
<h2>Edit Member Form</h2>
<form method="post" action="editmember.php">
<select name="member" id="member">
	<option selected="selected"></option>
	<?php
	$obj = new Members();
	$results = $obj->getMembersAll();
	foreach($results as $result){
		echo '<option value="'.$result['id'].'">'.$result['LastName'].', '.$result['FirstName'].'</option>';
	}
	?>
</select>
<input type="submit" name ="submit" value="Edit Member">
<input type="hidden" name="validation">
</form>


<?php 

//Checks for member selected to be edited
if (isset($_POST['validation'])) {
	$memberID = $_POST['member'];
	$_SESSION['editID'] = $memberID;
	$members = $obj->memberInfo($memberID);
	foreach ($members as $member){
		echo "<form method='post' action='savedMember.php'>";
		echo "<table>";
		echo "<tr>";
		echo "<td>First Name</td>";
		echo "<td><input type='text' name='newFirstName' value='".$member['FirstName']."'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Last Name</td>";
		echo "<td><input type='text' name='newLastName' value='".$member['LastName']."'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Address</td>";
		echo "<td><input type='text' name='newAddress' value='".$member['Address']."'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Phone</td>";
		echo "<td><input type='text' name='newPhone' value='".$member['Phone']."'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Email</td>";
		echo "<td><input type='text' name='newEmail' value='".$member['Email']."'></td>";
		echo "</tr>";
		echo '<tr>';
		echo '<td>Current Member</td>';
		echo "<td><select name='newCurrent'>";
		echo '<option value="1"';
		if ($member['current']==1) {
			echo 'selected="selected"';
		}
		echo '>Yes</option>';
		echo '<option value="2"';
		if ($member['current']==2) {
			echo 'selected="selected"';
		}
		echo '>No</option>';
		echo '</select></td>';
		echo '</tr>';
		echo '<tr>';
		//When form submitted, it goes to savedMember.php so show results and call functions
		echo '<input type="hidden" name="validation2">';
		echo '<td><input type="submit" name="submit2" value="Save Changes"></td>';
		echo '<td><a href="admin.php"><input type="button" value="Cancel"></a></td>';
		echo '</tr>';
		echo "</table>";
		echo "</form>";
	}
}



?>


