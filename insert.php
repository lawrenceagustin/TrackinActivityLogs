<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit a applicant</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<h1>Insert applicant!</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="firstName">First Name</label> 
			<input type="text" name="first_name">
		</p>
		<p>
			<label for="lastName">Last Name</label> 
			<input type="text" name="last_name">
		</p>
		<p>
			<label for="nationality">Nationality</label> 
			<input type="text" name="nationality">
		</p>
		<p>
			<label for="age">Age</label> 
			<input type="text" name="age">
		</p>
		<p>
		<label for="gender">Gender:</label>
    <select name="gender" id="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Others">Others</option>
        <option value="Prefer not to say">Prefer not to say</option>
    </select>
		</p>
		<p>
			<label for="email">Email</label> 
			<input type="text" name="email">
		</p>
		<p>
			<label for="contactNo">Contact No.</label> 
			<input type="text" name="contact_no">
		</p>
		<p>
			<label for="homeAddress">Home Address</label> 
			<input type="text" name="home_address">
		</p>
		<p>
		<label for="position">Position:</label>
    <select name="position" id="position">
        <option value="Community Outreach">Community Outreach</option>
        <option value="Food Distribution">Food Distribution</option>
        <option value="Medical Support">Medical Support</option>
        <option value="Shelter Management">Shelter Management</option>
				<option value="Logistics Coordination">Logistics Coordination</option>
				<option value="Shelter Management">Shelter Management</option>
    </select>
		</p>
		<p>
			<label for="locationPreference">Location Preference</label> 
			<input type="text" name="location_pref">
			<br><br>
			<input type="submit" name="insertApplicantBtn">
		</p>
	</form>
	<button onclick="window.location.href='index.php';">Back</button>
</body>
</html>