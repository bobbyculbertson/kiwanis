<?php 
class GoldenGate {
	public $connection;
	public function getCredentials(){
		$arr = parse_ini_file('configdb.ini');

		try {
			$this->connection = new PDO($arr['dsn'], $arr['user'], $arr['pass']);
		}
		catch(PDOException $e) {
			echo 'Connection Failed :'.$e->getMessage().PHP_EOL;
			echo 'Please contact the application administrator';
		}
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
		$sql = "SELECT SUM(v.visits) AS QtrVisits, m.FirstName
		FROM visits v JOIN members m
		ON (v.memberID = m.id)
		WHERE v.date >= :startDate AND
		v.date <= :endDate
		GROUP BY m.FirstName
		ORDER BY m.Firstname";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execut(array(':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			return $results;
		} else {
			echo 'No Results';
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
		WHERE date >= :startDate AND date <= :endDate AND memberID = :memberID";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':startDate'=>$startDate, ':endDate'=>$endDate, ':memberID'=>$memberID));
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
	public function duesVisits($memberID, $startDate, $endDate) {
		parent::getCredentials();
		$sql = "SELECT SUM(visits) as QtrVisits FROM visits WHERE memberID=:memberID AND date >= :startDate AND date <= :endDate";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':memberID'=>$memberID, ':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			$visits = $results[0]['QtrVisits'];
			if ($visits > 6) {
				$duesVisits = 9.2*($visits-6);
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
		parent::getCredentials();
		$sql = "SELECT COUNT(type) as Visitors FROM guests WHERE memberToBill=:memberID AND date >= :startDate AND date <= :endDate";
		$stm = $this->connection->prepare($sql);
		$results = $stm->execute(array(':memberID'=>$memberID, ':startDate'=>$startDate, ':endDate'=>$endDate));
		if($results = $stm->fetchAll(PDO::FETCH_ASSOC)){
			$guests = $results[0]['Visitors'];
			$duesGuests = 9.2*$guests;
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
	function __destruct(){
		$this->connection=null;
	}
}


	?>