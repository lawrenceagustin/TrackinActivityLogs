<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; 
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Delete Applicant</title>
</head>
<body>
	<h1>Are you sure you want to delete this user?</h1>
	<?php $getApplicantByID = getApplicantByID($pdo, $_GET['id']); ?>
	<div class="container" style="border-style: solid; border-color: red; background-color: #ffcbd1;height: 500px;">
		<h2>First Name: <?php echo $getApplicantByID['first_name']; ?></h2>
		<h2>Last Name: <?php echo $getApplicantByID['last_name']; ?></h2>
    <h2>Nationality: <?php echo $getApplicantByID['nationality']; ?></h2>
    <h2>Age: <?php echo $getApplicantByID['age']; ?></h2>
    <h2>Gender: <?php echo $getApplicantByID['gender']; ?></h2>
		<h2>Email: <?php echo $getApplicantByID['email']; ?></h2>
		<h2>Contact No.: <?php echo $getApplicantByID['contact_no']; ?></h2>
    <h2>Home Address: <?php echo $getApplicantByID['home_address']; ?></h2>
    <h2>Position: <?php echo $getApplicantByID['position']; ?></h2>
    <h2>Location Preference: <?php echo $getApplicantByID['location_pref']; ?></h2>
		<div class="deleteBtn" style="float: right; margin-right: 10px;">
			<form action="core/handleForms.php?id=<?php echo $_GET['id']; ?>" method="POST">
				<input type="submit" name="deleteApplicantBtn" value="Delete" style="background-color: #f69697; border-style: solid;">
			</form>			
		</div>	
	</div>
</body>
</html>