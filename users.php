<?php 	// Grant Schorgl Assignment 7 11/8/2016
$pagetitle = 'Current Users';
require ('includes/config.inc.php'); 
include ('includes/header.html';)
require ('includes/mysqli_connect.php';)


$concat = "SELECT CONCAT(last_name, ', ', first_name) AS name, DATE_FORMAT(registration_date, '%M %d, %Y') 
	AS dr, status AS status FROM users ORDER BY registration_date ASC";
echo '<h1 class="header" align="center">Register Users</h1>';
$results = mysqli_query($dbc, $concat);
$num = @mysqli_num_rows($results);

 if ($num > 0 ) 
{
	echo "<p align='center'>there are currently $num registered users.</p>\n";
	echo 
	'<table class="table">
		<thead>
			<tr>
				<th align="left">	<br>Name</br>				</th>
				<th align="left">	<br>Date Registered</br>	</th>
				<th align="left">	<br>User Status</br>	    </th>
			</tr>
		</thead>';
		while ($row =mysqli_fetch_array($results, MYSQLI_ASSOC)) 
			{echo 
		'<tr>
			<td align="left"> ' . $row['name'] . '	</td>
			<td align="left">  ' .$row['dr'] . '		</td>
			<td align="left">  ' .$row['status'] . '		</td>
		</tr>';}
	echo '</table>';
	mysqli_free_result ($results);
}
else
{
	echo '<p  class="alert alert-danger">The current users could not be retrieved. We apologize for any inconvenience.</p>';
	echo '<p>' .mysqli_error($dbc) . '</br></br> Query: ' . $concat . '</p>';
}
mysqli_close($dbc);
include 'includes/footer.html';
?>
