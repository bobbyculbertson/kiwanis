<?php 
session_start();
?>

<!DOCTYPE = html>
<html>
<head>
<title><?php echo $title?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="banner">
	<header>
		<h2>Kiwanis Treasurer</h2>
			<nav>
				<ul>
					<li>Members
						<ul>
							<li><a href="addmember.php">Add</a></li>
							<li><a href="editmember.php">Edit</a></li>
						</ul>
					</li>
					<li>Attendance
						<ul>
							<li><a href="attendance.php">Members</a></li>
							<li><a href="guests.php">Guests</a></li>
						</ul>
					</li>
					<li><a href="memberaccount.php">Accounts</a></li>
					<li><a href="dues.php">Dues</a></li>
					<li><a href="bill.php">Bills</a></li>
				</ul>
			</nav>
	</header>
</div>
<!-- <div class="clear"></div> -->
<div id="wrapper">
	<article>
	
	
	
	

