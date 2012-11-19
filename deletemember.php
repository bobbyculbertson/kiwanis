<?php 
//Title variable passed to header to give page a Title
$title = "Delete Member";
require_once 'header.php';
require_once 'class.php';
?>
<h2>Delete Member Form</h2>
<form method="post" action="deletemember.php">
<select name="member" id="member">
	<option selected="selected"></option>
	<?php
	//Builds combo box of all members
	$obj = new Members();
	$results = $obj->getMembersAll();
	foreach($results as $result){
		echo '<option value="'.$result['id'].'">'.$result['LastName'].', '.$result['FirstName'].'</option>';
	}
	?>
</select>
<input type="submit" name ="submit" value="Delete Member">
<input type="hidden" name="validation">
</form>


<?php 

//Checks for member selected to be Deleted
if (isset($_POST['validation'])) {
	$memberID = $_POST['member'];
	//Creates session ID, so when second form is built confirming Member Delete, the ID will get passed
	//Into calling the class method and build the query
	$_SESSION['deleteID'] = $memberID;
	echo "Are you sure you want to delete this member?";
	$members = $obj->memberInfo($memberID);
	foreach ($members as $member){
		echo "<form method='post' action='deletemember.php'>";
		echo "<table>";
		echo "<tr>";
		echo "<td>First Name</td>";
		echo "<td>".$member['FirstName']."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Last Name</td>";
		echo "<td>".$member['LastName']."<td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Address</td>";
		echo "<td>".$member['Address']."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Phone</td>";
		echo "<td>".$member['Phone']."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Email</td>";
		echo "<td>".$member['Email']."</td>";
		echo "</tr>";
		echo '<tr>';
		echo '<td>Current Member</td>';
		echo "<td><select name='newCurrent'>";
		echo '<option value="1"';
		//Sets combo to current status value
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
		echo '<input type="hidden" name="validation2">';
		echo '<td><input type="submit" name="submit2" value="Yes"></td>';
		echo '<td><a href="admin.php"><input type="button" value="Cancel"></a></td>';
		echo '</tr>';
		echo "</table>";
		echo "</form>";
	}
}

if(isset($_POST['validation2'])) {
	//If choose Yes to Delete Member
	 $deleteMemberID = $_SESSION['deleteID'];
	 $deleteMember = $obj->deleteMember($deleteMemberID);
	 echo $deleteMember;
}



?>


