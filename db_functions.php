
<?php
$server_connection = array(	'server' 	=> 'localhost',
		'database' 	=> 'kiwanis',
		'un' 	=> 'bobby',
		'pw' 	=> '!Superior.2406!');
	
//FUNCTION TO CALL QUERIES OR FUNCTIONS
//RETURNS: ARRAY OF ALL VALUES REQUESTED
function call_all($query) {

	//DECLARE ROWS AS NULL TO AVOID ERRORS
	$rows = array();

	global $server_connection;
	$db = new mysqli($server_connection['server'], $server_connection['un'], $server_connection['pw'], $server_connection['database']);
	if (mysqli_connect_errno()){
		echo "<div>'Cannot connect to database:'  .mysqli_connect_error()</div>";
	}else
	{
		$result = $db->query($query);

		//MAKE RESULT INTO ARRAY
		while($row = $result->fetch_array())
		{$rows[] = $row;}

		//CLOSE MYSQLI RESOURCES
		$result->close();
		$db->close();

		//RETURN RESULT
		return $rows;
	}
}

//FUNCTION TO CALL QUERIES OR FUNCTIONS
//RETURNS: RESULT OF QUERY.
function call($query) {

	global $server_connection;
	$db = new mysqli($server_connection['server'], $server_connection['un'], $server_connection['pw'], $server_connection['database']);
	if (mysqli_connect_errno()){
		echo "<div>'Cannot connect to database:'  .mysqli_connect_error()</div>";
	}else
	{
		$result = $db->query($query);

		//CLOSE MYSQLI RESOURCES
		$db->close();

		//RETURN RESULT
		return $result;
	}
}

//USED TO INSERT NEW USER AND DELELTE USER FROM DATABASE
function call_add($query) {

	global $server_connection;
	$db = new mysqli($server_connection['server'], $server_connection['un'], $server_connection['pw'], $server_connection['database']);
	if (mysqli_connect_errno()){
		echo "<div>'Cannot connect to database:'  .mysqli_connect_error()</div>";
	}else
	{
		//INSERT VARIABLES FROM FORM INTO USERS DATABASE
		$insert = $db->query($query);

		if (!$insert) {
			$message ="There was an error. Record not added. Please contact the web administrator";
		} else {
			$message ="Action Completed Successfully";
		}

		echo $message;
		//CLOSE MYSQLI RESOURCES
		$db->close();
	}
}