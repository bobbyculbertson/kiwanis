<?php
require_once 'functions.php';


if (isset($_POST['validation2'])) {
	$newFirstName = strip_tags(trim($_POST['newFirstName']));
	$newLastName = strip_tags(trim($_POST['newLastName']));
	$newAddress = strip_tags(trim($_POST['newAddress']));
	$newPhone = strip_tags(trim($_POST['newPhone']));
	$newEmail = strip_tags(trim($_POST['newEmail']));
	$newCurrent = strip_tags(trim($_POST['newCurrent']));

	$editResults = editMember($newFirstName, $newLastName, $newAddress, $newPhone, $newEmail, $newCurrent, $_SESSION['editID']);
	echo $editResults;
	echo "<br><a href='admin.php'>Return to Admin Page</a>";
} else {
	echo "not working";
}