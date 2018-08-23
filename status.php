<?php 	// Grant Schorgl Assignment 7 11/8/2016
require ('includes/config.inc.php'); 
$pagetitle = 'Change Your Status';
include ('includes/header.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('includes/mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}

	// Check for the current password:
	/*if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your current password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	}*/
	If ($_POST['Status'] == 'A')
		{
		$Status = 'A';
		}
	else
		{
		$Status = 'I';
		}
	
	if (empty($_POST['Status'])) {
		$errors[] = 'You forgot to enter your status.';
	} else {
		$s = mysqli_real_escape_string($dbc, trim($_POST['Status']));
	}
	
	if (empty($errors)) { // If everything's OK.
		// Check that they've entered the right email address/password combination:
		$q = "SELECT user_id,status FROM users WHERE (email='$e')";
		$r = @mysqli_query($dbc, $q);
		$num = @mysqli_num_rows($r);
		
		if ($num > 0) { // Match was made.
	
			// Get the user_id:
			$row = mysqli_fetch_array($r, MYSQLI_NUM);
			if ($row[1] != $s)
			{
				// Make the UPDATE query:
				$q = "UPDATE users SET status='$s' WHERE user_id=$row[0]";		
				$r = @mysqli_query($dbc, $q);
			
				if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message.
				echo '<h1>Thank you!</h1>
				<p>Your status has been updated.<br /></p>';	

				} else { // If it did not run OK.

				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">Your status could not be changed due to a system error. We apologize for any inconvenience.</p>'; 
	
				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
	
				}
			}
			else {
					if( $s == 'A')
					{
					echo '<p>Your Status Is already Active </p>';
					}
					else
					{
					echo '<p>Your Status Is already Inactive </p>';
					}
				 }
				
			mysqli_close($dbc); // Close the database connection.

			// Include the footer and quit the script (to not show the form). 
			exit();
				
		} else { // Invalid email address/password combination.
			echo '<p  class="alert alert-danger">The email address and or password do not match those on file.</p>';
		}
		mysqli_close($dbc);
	} else { // Report the errors.

		echo '<p class="alert alert-danger">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
	
	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.
		
} // End of the main Submit conditional.
?>
<div class="container">

<form action="status.php" method="post">
	<fieldset>
		<legend>Change Your Sataus</legend>
		<p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
		<!--<p>Password: <input type="password" name="pass" size="30" maxlength="50" value="<?php //if (isset($_POST['pass'])) echo $_POST['pass']; ?>"  /></p>-->
		<p><label>Status:
		<input type="radio" name="Status" id="A"  value ="A" required="required" checked="checked"/> Active
		<input type="radio" name="Status" id="I"  Value ="I" required="required"/> Inactive</label>
		<input type="submit" name="submit" value="Change Status" /></p>
	</fieldset>
</form>
</div>
<?php include ('includes/footer.html'); ?>