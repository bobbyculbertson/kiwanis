<?php 
$title = "Category";
require_once 'header.php';
?>
<html>
<body>
<a href="admin.php">Back to Admin Page</a>
<form method="post" action="category.php">
	<table>
		<tr>
			<td>Category</td>
			<td><input type="text" name="category"></td>
		</tr>
		<tr>
			<td>Account</td>
			<td><select name="account" id="account">
					<option selected="selected"></option>
					<?php 
					$result = accountCombo();
					
					while ($row = $result->fetch_array()){
						echo '<option value="'.$row['id'].'">'.$row['account'].'</option>';
					}
				
					?>
					
			</select></td>
		</tr>
		<tr>
			<td><input type="submit" name="add" value="Add Category"></td>
			<td><a href="admin.php"><input type="button" value="Cancel"></a></td>
		</tr>
	</table>
<input type="hidden" name="validation">
</form>

<?php 
if (isset($_POST['category'])){
	$category = strip_tags(trim($_POST['category']));
	$account  = $_POST['account'];
	$results =addCategory($category, $account);
	echo $results;
	}


?>