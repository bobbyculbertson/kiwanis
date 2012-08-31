<?php
$title = "Add Member";
require_once 'header.php';

?>
<p><a href="admin.php">Back to Admin Section</a></p>
<form method="post" action="addmember.php">
	<table>
		<tr>
			<td>First Name</td>
			<td><input type="text" name="FirstName"></td>
		</tr>
		<tr>
			<td>Last Name</td>
			<td><input type="text" name="LastName"></td>
		</tr>
		<tr>
			<td>Address</td>
			<td><Input type="text" name="address"></td>
		</tr>
		<tr>
			<td>Phone</td>
			<td><input type="text" name="phone"></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td><input type="submit" name="add" value="Add Member"></td>
			<td><a href="admin.php"><input type="button" value="Cancel"></a></td>
		</tr>
	</table>
</form>


<?php 
if (isset($_POST['FirstName'])){
	$firstName = trim($_POST['FirstName']);
	$lastName = trim($_POST['LastName']);
	$address = trim($_POST['address']);
	$phone = trim($_POST['phone']);
	$email = trim($_POST['email']);
	addMember($firstName, $lastName, $address, $phone, $email);
}

?>
