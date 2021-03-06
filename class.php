<?php 
class GoldenGate {
	//Builds connection to database
	public $connection;
	public function getCredentials(){
		$arr = parse_ini_file('goldenGate.ini');

		try {
			$this->connection = new PDO($arr['dsn'], $arr['user'], $arr['pass']);
		}
		catch(PDOException $e) {
			echo 'Connection Failed :'.$e->getMessage().PHP_EOL;
			echo 'Please contact the application administrator';
		}
	}
}

class Dues extends GoldenGate {
	public function getVariables() {
		parent::getCredentials();
		$sql = "SELECT * FROM variable";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			$var['price']=$results[0]['value'];
			$var['quarter']=$results[1]['value'];
			$var['membership']=$results[2]['value'];
			return $var;
		} else {
			echo 'No Results';
		}
	}
	public function setVariables($value, $id) {
		parent::getCredentials();
		$sql = "UPDATE variable SET value=:value WHERE id=:id";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':value'=>$value, ':id'=>$id));
		if(!$results) {
			$message = 'Error occurred. Please try again.';
		} else {
			$message = 'Success';
		} return $message;
	}
	function __destruct(){
		$this->connection=null;
	}
}

class Members extends GoldenGate {
	public function setNewMember($firstName, $lastName, $address, $phone, $email){
		parent::getCredentials();
		$sql = "INSERT INTO members (FirstName, LastName, Address, Phone, Email)
		VALUES (:firstName, :lastName, :address, :phone, :email)";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':firstName' => $firstName, ':lastName'=>$lastName, ':address'=>$address, ':phone'=>$phone,':email'=>$email));
		if(!$results){
			$message = "No Results";
		} else {
			$message = 'Success';
		}
		return $message;
	}
	public function memberInfo($memberID) {
		parent::getCredentials();
		$sql = "SELECT * FROM members WHERE id = :memberID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':memberID'=>$memberID));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function getMembersAll(){
		parent::getCredentials();
		$sql = "SELECT * FROM members ORDER BY LastName";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function getCurrentMembers(){
		parent::getCredentials();
		$sql = "SELECT * FROM members WHERE current = 1 ORDER BY LastName";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function setMember($newFirstName, $newLastName, $newAddress, $newPhone, $newEmail, $newCurrent, $memberID){
		parent::getCredentials();
		$sql = "UPDATE members
		SET FirstName=:newFirstName, LastName=:newLastName, Address=:newAddress, Phone=:newPhone, Email=:newEmail, current=:newCurrent
		WHERE id=:memberID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':newFirstName'=>$newFirstName, ':newLastName'=>$newLastName, ':newAddress'=>$newAddress, ':newPhone'=>$newPhone, ':newEmail'=>$newEmail, ':newCurrent'=>$newCurrent, ':memberID'=>$memberID ));
		if(!$results){
		$message = 'No Results';
		} else {
			$message = 'Success';
		} return $message;
	}
	public function deleteMember($memberDeleteID) {
		parent::getCredentials();
		$sql = "DELETE FROM members WHERE id=$memberDeleteID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if(!$results){
			$message = "Record Not Deleted";
		} else {
			$message = 'Success';
		}
		return $message;
	}
	function __destruct(){
		$this->connection=null;
	}
}

class Visits extends GoldenGate {
	public function setVisit($date, $memberID, $visits, $comments){
		parent::getCredentials();
		$sql = "INSERT INTO visits (date, memberID, visits, comments )
		VALUES (:date,:memberID,:visits, :comments)";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':date' => $date, ':memberID' => $memberID, ':visits' => $visits, ':comments'=>$comments));
		if(!$results){
			$message = "No Results";
		} else {
			$message = 'Success';
		}
		return $message;
	}
	public function getSumVisits($startDate, $endDate){
		parent::getCredentials();
		$sql = "SELECT SUM(v.visits) AS QtrVisits, m.FirstName, m.LastName
		FROM visits v JOIN members m
		ON (v.memberID = m.id)
		WHERE v.date >= :startDate AND
		v.date <= :endDate
		GROUP BY m.FirstName
		ORDER BY m.Firstname";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	
	public function getVisits($startDate, $endDate) {
		parent::getCredentials();
		$sql = "SELECT v.id, v.date, v.visits, m.FirstName, m.LastName
				FROM visits v
					JOIN members m ON (m.id=v.memberID)
				WHERE date >= :startDate AND date <= :endDate
				ORDER BY v.date DESC, m.FirstName";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':startDate' => $startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function selectVisits($visitDeleteID) {
		parent::getCredentials();
		$sql = "SELECT v.id, v.date, v.visits, m.FirstName, m.LastName
				FROM visits v
					JOIN members m ON (m.id=v.memberID)
				WHERE v.id=$visitDeleteID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function deleteVisits($visitDeleteID) {
		parent::getCredentials();
		$sql = "DELETE FROM visits WHERE id=$visitDeleteID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if(!$results){
			$message = "Record Not Deleted";
		} else {
			$message = 'Success';
		}
		return $message;
	}
	
	public function distinctVisits($startDate, $endDate){
		parent::getCredentials();
		$sql = "SELECT DISTINCT date FROM visits WHERE date >= :startDate AND date <= :endDate";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			$message =  'No Results';
			return $message;
		}
	}
	function __destruct(){
		$this->connection=null;
	}
}

class Accounts extends GoldenGate {
	public function setAmount($date, $memberID, $amount, $comments){
		parent::getCredentials();
		$sql = "INSERT INTO memberAccounts (memberID, date, amount, comments)
		VALUES (:memberID,:date,:amount,:comments)";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':date' => $date, ':memberID' => $memberID, ':amount' => $amount, ':comments' => $comments));
		if(!$results){
			$message = "No Results";
		} else {
			$message = 'Success';
		}
		return $message;
	}
	public function setDues($memberID, $amount, $comments) {
		parent::getCredentials();
		$sql = "INSERT INTO memberAccounts (memberID, date, amount, comments)
		VALUES (:memberID, NOW(), :amount, :comments)";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':memberID'=>$memberID, ':amount'=>$amount, ':comments'=>$comments));
		if(!$results){
			$message = "No Results";
		} else {
			$message = "Success";
		}
		return $message;
	}
	public function getAccountSummary($startDate, $endDate, $memberID){
		parent::getCredentials();
		$sql = "SELECT * FROM memberAccounts
		WHERE date >= :startDate AND date <= :endDate AND memberID = :memberID ORDER BY date DESC";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':startDate'=>$startDate, ':endDate'=>$endDate, ':memberID'=>$memberID));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function getAccountRecords($startDate, $endDate) {
		parent::getCredentials();
		$sql = "SELECT * FROM memberAccounts WHERE date >= :startDate AND date <= :endDate";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function getAccounts($startDate, $endDate) {
		parent::getCredentials();
		$sql = "SELECT a.id, a.date, a.amount, a.comments, m.FirstName, m.LastName
				FROM memberAccounts a
					JOIN members m ON (a.memberID = m.id)
				WHERE date >= :startDate AND date <= :endDate
				ORDER BY date DESC";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function selectAccounts($AccountDeleteID) {
		parent::getCredentials();
		$sql = "SELECT a.id, a.date, a.amount, a.comments, m.FirstName, m.LastName
				FROM memberAccounts a
					JOIN members m ON (a.memberID = m.id)
				WHERE a.id= $AccountDeleteID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function getAccountBalance($memberID){
		parent::getCredentials();
		$sql = "SELECT SUM(amount) as balance FROM memberAccounts WHERE memberID=:memberID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':memberID'=>$memberID));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function getAllAccountBalance(){
		parent::getCredentials();
		$sql = "SELECT m.FirstName, m.LastName, SUM(a.amount) as balance 
				FROM memberAccounts a
					JOIN members m ON (a.memberID = m.id)
				GROUP BY m.LastName, m.id";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function duesVisits($memberID, $startDate, $endDate) {
		$var = Dues::getVariables();
		
		$sql = "SELECT SUM(visits) as QtrVisits FROM visits WHERE memberID=:memberID AND date >= :startDate AND date <= :endDate";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':memberID'=>$memberID, ':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			$visits = $results[0]['QtrVisits'];
			if ($visits > $var['quarter']) {
				$duesVisits = $var['price']*($visits-$var['quarter']);
			}else {
				$duesVisits = 0;
			}
			if ($duesVisits != 0) {
				$commentsVisits = "Meal dues for $visits total visits";
				$sql2 = "INSERT INTO memberAccounts (memberID, date, amount, comments) VALUES (:memberID, NOW(), :duesVisits, :commentsVisits)";
				$stm2 = $this->connection->prepare($sql2);
				$results2 = $stm2->execute(array(':memberID'=>$memberID, ':duesVisits'=>$duesVisits, ':commentsVisits'=>$commentsVisits));
				echo 'Entered '.$commentsVisits." for MemberID: $memberID<br>";
			} else {
				echo "Did not enter meal dues for $memberID <br>";
			}
		} else {
			echo 'No Results';
		}
	}
	public function setGuests($memberID, $startDate, $endDate) {
		$var=Dues::getVariables();
		
		$sql = "SELECT COUNT(type) as Visitors FROM guests WHERE memberToBill=:memberID AND date >= :startDate AND date <= :endDate";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':memberID'=>$memberID, ':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			$guests = $results[0]['Visitors'];
			$duesGuests = $var['price']*$guests;
			if($duesGuests > 0){
				$commentsGuests = "Meals for $guests Guests";
				$sql2 = "INSERT INTO memberAccounts (memberID, date, amount, comments) VALUES (:memberID, NOW(), :duesGuests, :commentsGuests)";
				$stm2 = $this->connection->prepare($sql2);
				$results2 = $stm2->execute(array(':memberID'=>$memberID, ':duesGuests'=>$duesGuests, ':commentsGuests'=>$commentsGuests));
				echo 'Entered '.$commentsGuests. " for MemberID: $memberID<br>";
			} else {
				echo "Did not enter meals for Guests <br>";
			}
		} else {
			echo 'No Results';
		}
	}
	public function deleteAccount($AccountDeleteID) {
		parent::getCredentials();
		$sql = "DELETE FROM memberAccounts WHERE id=$AccountDeleteID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if(!$results){
			$message = "Record Not Deleted";
		} else {
			$message = 'Success';
		}
		return $message;
	}
	function __destruct(){
		$this->connection=null;
	}

}

class Guests extends GoldenGate {
	public function setGuests($date, $type, $memberToBill, $comments){
		parent::getCredentials();
		$sql = "INSERT INTO guests (date, type, memberToBill, comments)
		VALUES (:date, :type, :memberToBill, :comments)";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':date'=>$date, ':type'=>$type, ':memberToBill'=>$memberToBill, ':comments'=>$comments));
		if(!$results){
			$message = "No Results";
		} else {
			$message = "Success";
		}
		return $message;
	}
	public function getGuestType(){
		parent::getCredentials();
		$sql = "SELECT * FROM guestType";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function getGuests($startDate, $endDate) {
		parent::getCredentials();
		$sql = "SELECT *
				 FROM guests 
				WHERE date >= :startDate AND date <= :endDate ORDER BY date DESC";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function selectGuests($guestDeleteID) {
		parent::getCredentials();
		$sql = "SELECT * FROM guests WHERE id=$guestDeleteID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
		}
	}
	public function deleteGuest($guestDeleteID) {
		parent::getCredentials();
		$sql = "DELETE FROM guests WHERE id=$guestDeleteID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute();
		if(!$results){
			$message = "Record Not Deleted";
		} else {
			$message = 'Success';
		}
		return $message;
	}
	
	function __destruct(){
		$this->connection=null;
	}
}




	?>