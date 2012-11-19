<?php
//Title variable passed to header to give page a Title
$title = "Add Member";
require_once 'header.php';
require_once 'class.php';

?>
<h2>Add Member Form</h2>
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
		<input type="hidden" name="validation">
	</table>
</form>


<?php 
if (isset($_POST['validation'])){
	//Set variables to be passed to query
	$firstName = strip_tags(trim($_POST['FirstName']));
	$lastName = strip_tags(trim($_POST['LastName']));
	$address = strip_tags(trim($_POST['address']));
	$phone = strip_tags(trim($_POST['phone']));
	$email = strip_tags(trim($_POST['email']));
	//Call Members class
	$obj = new Members();
	//Pass variables to create new member
	$results = $obj->setNewMember($firstName, $lastName, $address, $phone, $email);
	//Returns Success or Failure
	echo $results;
}

?>
