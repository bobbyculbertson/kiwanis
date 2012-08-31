<?php

require_once "db_functions.php";
session_start();

function addVisit($memberID, $date, $visit, $comments) {
	$results= call_add("INSERT INTO visits (date, memberID, visits, comments) values ('$date','$memberID','$visit', '$comments')");
	return $results;
	}
	
function addAmount($memberID, $date, $amount, $comments) {
	$results= call_add("INSERT INTO memberAccounts (memberID, date, amount, comments) values ('$memberID', '$date','$amount','$comments')");
	return $results;
}

function memberComboAll(){
	$results = call("Select * from members order by LastName");
	if (count($results) == 0) {
		echo "<div><strong>Error:</strong> Problem with User selected. Please go back and try again.</div>";
	} else {
		return $results;
	}
}
function memberComboCurrent(){
	$results = call("Select * from members WHERE current= 1 order by LastName ");
	if (count($results) == 0) {
			echo "<div><strong>Error:</strong> Problem with User selected. Please go back and try again.</div>";
		} else {
		return $results;
		}
}

function addMember($firstName, $lastName, $address, $phone, $email) {
	$results= call_add("INSERT INTO members (FirstName, LastName, Address, Phone, Email) values ('$firstName', '$lastName', '$address', '$phone', '$email')");
	return $results;
}

function accountSummary($startDate, $endDate, $memberID) {
	
	$results = call("SELECT * FROM memberAccounts 
					WHERE date >= '$startDate' and date <= '$endDate' and
					memberID = $memberID");
	if (!$results) {
		echo "No Results";
	}
	return $results;
}


function accountBalance($memberID) {
	$results = call("SELECT SUM(amount) as balance FROM memberAccounts where memberID=$memberID");
	$row = $results->fetch_array();
	$total = $row['balance'];
	
	return $total;
}

function memberInfo($memberID) {
	$results = call("SELECT * FROM members WHERE id = $memberID Limit 1");
	if (!$results){
		echo "No Member Results";
	} else {
	return $results;
}
}

function dues($memberID, $dues, $commentsDues) {
	$results = call("INSERT INTO memberAccounts (memberID, date, amount, comments) VALUES ('$memberID', NOW(), '$dues', '$commentsDues')");
	if (!$results) {
		echo "Did not insert membership dues for $memberID";
	}
}

function meals($memberID, $meals, $commentsMeals) {
	$results = call("INSERT INTO memberAccounts (memberID, date, amount, comments) VALUES ('$memberID', NOW(), '$meals', '$commentsMeals')");
	if (!$results) {
		echo "Did not insert base meal dues for $memberID";
	}
}

function duesVisits($memberID, $startDate, $endDate) {
	$result = call("SELECT SUM(visits) as QtrVisits FROM visits WHERE memberID=$memberID AND date >= '$startDate' AND date <= '$endDate'");
	$row = $result->fetch_array();
	$visits = $row['QtrVisits'];
	if ($visits > 6) {
		$duesVisits = 9.2*($visits-6);
	}else {
		$duesVisits = 0;
	}
	if ($duesVisits != 0) {
	$commentsVisits = "Meal dues for $visits total visits";
	$results = call("INSERT INTO memberAccounts (memberID, date, amount, comments) VALUES ('$memberID', NOW(), '$duesVisits', '$commentsVisits')");
	
	} else {
		echo "Did not enter meal dues for $memberID <br>";
	}
	
}

function sumVisits($startDate, $endDate) {
	$results = call("SELECT SUM(v.visits) AS QtrVisits, m.FirstName 
			FROM visits v JOIN members m 
			ON (v.memberID = m.id)
			WHERE v.date >= '$startDate' AND
			v.date <= '$endDate' 
			GROUP BY m.FirstName
			ORDER BY m.Firstname");
	if (!$results){
		echo "no results<br>";
	} else {
	echo "Attendance Summary";
	echo "<table>";
	while($row = $results->fetch_array()) {
		echo "<tr>";
		echo "<td>".$row['FirstName']."</td>";
		echo "<td>".$row['QtrVisits']."</td>";
		echo "</tr>";
	}
	echo "</table>";
	}
}

function editMember($newFirstName, $newLastName, $newAddress, $newPhone, $newEmail, $newCurrent, $memberID) {
	$results = call("UPDATE members SET FirstName='$newFirstName', LastName='$newLastName', Address='$newAddress', Phone='$newPhone', Email='$newEmail', current='$newCurrent' WHERE id='$memberID'");
	if (!$results) {
		$message = "Update failed. Please try again";
	} else {
		$message = "Changes Saved";
	} return $message;
}

function accountCombo(){
	$results = call("SELECT * from accountType");
	if (count($results) == 0) {
		echo "<div><strong>Error:</strong> Problem with Accounts selected. Please go back and try again.</div>";
	} else {
		return $results;
	}
}

function categoryCombo(){
	$results = call("SELECT * from accountCategories");
	if (count($results) == 0) {
		echo "<div><strong>Error:</strong> Problem with Accounts selected. Please go back and try again.</div>";
	} else {
		return $results;
	}
}

function addCategory($category, $account) {
	$results= call("INSERT INTO accountCategories (category, account) values ('$category', '$account')");
	if (!$results){
		$message = "Record did not insert. Please Try Again";
	} else {
		$message = "Record Added Successfully";
	}
	return $message;
}

function addClubAccount($date, $account, $type, $amount, $category, $comments) {
	$results= call("INSERT INTO clubaccountrecords (date, account, type, amount, category, comments) values ('$date', '$account', '$type', '$amount', '$category', '$comments')");
	if (!$results){
		$message = "Record did not insert. Please Try Again";
	} else {
		$message = "Record Added Successfully";
	}
	return $message;
	
}

function clubAccountSummary($account) {
	$results = call("SELECT * FROM clubaccountrecords WHERE account=$account");
	return $results;
}

function clubAccountBalance($account) {
	$results = call("SELECT SUM(amount) as balance FROM clubaccountrecords WHERE account=$account");
	$row = $results->fetch_array();
	$total = $row['balance'];
	return $total;
}
	