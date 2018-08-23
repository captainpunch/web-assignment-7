<?php	// Grant Schorgl Assignment 7 11/8/2016
require ('includes/config.inc.php'); 
$pagetitle = 'Register';
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();
	if (empty($_POST['first_name'])) {$errors[] = 'enter your first name.';}
	else {$fn = trim($_POST['first_name']);}
	if (empty($_POST['last_name'])) {$errors[] = 'enter your last name.';}
	else {$ln = trim($_POST['last_name']);}
	if (empty($_POST['email'])) {$errors[] = 'enter your email.';}
	else {$e = trim($_POST['email']);}
	if (!empty($_POST['pass1'])) 
	{   
	if ($_POST['pass1'] != $_POST['pass2']) {$errors[] = 'Password did not match.';}
	else {$p = trim($_POST['pass1']);}
	}
	else {$errors[] = 'enter your password.';}
	
	if (empty($errors)) 
	{ 		
		require ('includes/mysqli_connect.php');
		$q = "INSERT INTO users (first_name, last_name, email, pass, registration_date) VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW() )";		
		$r = @mysqli_query ($dbc, $q);
		if ($r) 
		{
			echo '<h1>Thank you!</h1>
			<p>You are now registered. </p><p><br></p>';	
		} else {
			echo '<h1 class="alert alert-danger">System Error</h1>
			<p class="alert alert-danger">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';
		}
		mysqli_close($dbc); 
		include ('includes/footer.html'); 
		exit();
	} 
	else 
	{ 	
		echo '<h1 class="alert alert-danger">Error!</h1>
		<p class="alert alert-danger">The following error(s) occurred:<br />';
		foreach ($errors as $msg) {	echo " - $msg<br />\n";}
		echo '</p>	<p>Please try again.</p>	<br>';	
		//mysqli_close($dbc);
	}
	mysqli_close($dbc);
}
?>
<div class="container">
<form action="register.php" method="post">
	<fieldset>
	<legend> Register </legend>
		<label>First Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></label><br>
		<label>Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></label><br>
		<label>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </label><br>
		<label>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></label><br>
		<label>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"  /></label><br>
	<button class="btn" type="submit" name="submit" value="Register"> Register </button>
	</fieldset>
</form>
</div>
<?php include ('includes/footer.html'); ?>