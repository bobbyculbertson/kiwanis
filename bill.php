<?php
$title="Admin Page";
require_once 'header.php';
require_once 'class.php';
?>
<h2>Create Bill</h2>
<form method="post" action="memberbill.php">
<table>
<tr>
<td>Range for Account Summary</td>
</tr>
<tr>
<td>Start Date</td>
<td><input type="date" name="startDate"></td>
</tr>
<tr>
<td>End Date</td>
<td><input type="date" name="endDate"></td>
</tr>
<tr>
<td>Choose Member</td>
<td><select name="member" id="member2">
<option selected="selected"></option>
<?php
	$obj = new Members();
	$results = $obj->getCurrentMembers();
	foreach($results as $result){
		echo '<option value="'.$result['id'].'">'.$result['LastName'].', '.$result['FirstName'].'</option>';
	}
?>
			</select></td>
		</tr>
		<tr>
			<td><input type="hidden" name="validation"><input type="submit" name="choice" value="Create Bill"></td>
		</tr>
		
	</table>
	
</form>




