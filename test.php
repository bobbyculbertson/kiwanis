<?php
require_once 'class.php';
$memberID = 24;
$startDate = '2012-10-01';
$endDate = '2012-10-17';

$AccountObj = new Accounts();
$results = $AccountObj->setGuests($memberID, $startDate, $endDate);





