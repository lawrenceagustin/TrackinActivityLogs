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
	<title>Edit Applicant</title>
</head>
<body>
	<?php $getApplicantByID = getApplicantByID($pdo, $_GET['id']); ?>
	<h1>Edit the applicant!</h1>
	<form action="core/handleForms.php?id=<?php echo $_GET['id']; ?>" method="POST">
  <p>
	<label for="firstName">First Name</label> 
	<input type="text" name="first_name" value="<?php echo $getApplicantByID['first_name']; ?>">
</p>
<p>
	<label for="lastName">Last Name</label> 
	<input type="text" name="last_name" value="<?php echo $getApplicantByID['last_name']; ?>">
</p>
<p>
	<label for="nationality">Nationality</label> 
	<input type="text" name="nationality" value="<?php echo $getApplicantByID['nationality']; ?>">
</p>
<p>
	<label for="age">Age</label> 
	<input type="text" name="age" value="<?php echo $getApplicantByID['age']; ?>">
</p>
<p>
	<label for="gender">Gender:</label>
    <select name="gender" id="gender">
        <option value="Male" <?php echo ($getApplicantByID['gender'] == 'Male' ? 'selected' : ''); ?>>Male</option>
        <option value="Female" <?php echo ($getApplicantByID['gender'] == 'Female' ? 'selected' : ''); ?>>Female</option>
        <option value="Others" <?php echo ($getApplicantByID['gender'] == 'Others' ? 'selected' : ''); ?>>Others</option>
        <option value="Prefer not to say" <?php echo ($getApplicantByID['gender'] == 'Prefer not to say' ? 'selected' : ''); ?>>Prefer not to say</option>
    </select>
</p>
<p>
	<label for="email">Email</label> 
	<input type="text" name="email" value="<?php echo $getApplicantByID['email']; ?>">
</p>
<p>
	<label for="contactNo">Contact No.</label> 
	<input type="text" name="contact_no" value="<?php echo $getApplicantByID['contact_no']; ?>">
</p>
<p>
	<label for="homeAddress">Home Address</label> 
	<input type="text" name="home_address" value="<?php echo $getApplicantByID['home_address']; ?>">
</p>
<p>
	<label for="position">Position:</label>
    <select name="position" id="position">
        <option value="Community Outreach" <?php echo ($getApplicantByID['position'] == 'Community Outreach' ? 'selected' : ''); ?>>Community Outreach</option>
        <option value="Food Distribution" <?php echo ($getApplicantByID['position'] == 'Food Distribution' ? 'selected' : ''); ?>>Food Distribution</option>
        <option value="Medical Support" <?php echo ($getApplicantByID['position'] == 'Medical Support' ? 'selected' : ''); ?>>Medical Support</option>
        <option value="Shelter Management" <?php echo ($getApplicantByID['position'] == 'Shelter Management' ? 'selected' : ''); ?>>Shelter Management</option>
        <option value="Logistics Coordination" <?php echo ($getApplicantByID['position'] == 'Logistics Coordination' ? 'selected' : ''); ?>>Logistics Coordination</option>
    </select>
</p>
<p>
	<label for="locationPreference">Location Preference</label> 
	<input type="text" name="location_pref" value="<?php echo $getApplicantByID['location_pref']; ?>">
	<br><br>
	<input type="submit" value="Save" name="editApplicantBtn">
</p>
	</form>
	<button onclick="window.location.href='index.php';">Back</button>
</body>
</html>