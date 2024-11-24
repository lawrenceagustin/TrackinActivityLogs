<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; 
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Disaster Relief Application</title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>

<?php include 'navbar.php'; ?>


	<?php if (isset($_SESSION['message'])) { ?>
		<h1 style="color: green; text-align: center; background-color: ghostwhite; border-style: solid;">	
			<?php echo $_SESSION['message']; ?>
		</h1>
	<?php } unset($_SESSION['message']); ?>


	<form class="searchQ" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="GET">
		<input type="text" name="searchInput" placeholder="Search here">
		<input type="submit" name="searchBtn">
	</form>

	<p class="search"><a href="index.php">Clear Search Query</a></p>
	<table style="text-alig: center;">
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
      <th>Nationality</th>
      <th>Age</th>
      <th>Gender</th>
			<th>Email</th>
			<th>Contact No.</th>
      <th>Home Address</th>
			<th>Position</th>
			<th>Location Preference</th>
			<th>Date Added</th>
			<th>Action</th>
		</tr>

		<?php if (!isset($_GET['searchBtn'])) { ?>
			<?php $getAllApplicant = getAllApplicant($pdo); ?>
				<?php foreach ($getAllApplicant as $row) { ?>
					<tr>
						<td><?php echo $row['first_name']; ?></td>
						<td><?php echo $row['last_name']; ?></td>
						<td><?php echo $row['nationality']; ?></td>
						<td><?php echo $row['age']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['contact_no']; ?></td>
						<td><?php echo $row['home_address']; ?></td>
						<td><?php echo $row['position']; ?></td>
            <td><?php echo $row['location_pref']; ?></td>
            <td><?php echo $row['date_added']; ?></td>
						<td>
							<a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
							<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
						</td>
					</tr>
			<?php } ?>
			
		<?php } else { ?>
			<?php $searchForAApplicant =  searchForAApplicant($pdo, $_GET['searchInput']); ?>
				<?php foreach ($searchForAApplicant as $row) { ?>
					<tr>
            <td><?php echo $row['first_name']; ?></td>
						<td><?php echo $row['last_name']; ?></td>
						<td><?php echo $row['nationality']; ?></td>
						<td><?php echo $row['age']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['contact_no']; ?></td>
						<td><?php echo $row['home_address']; ?></td>
						<td><?php echo $row['position']; ?></td>
            <td><?php echo $row['location_pref']; ?></td>
            <td><?php echo $row['date_added']; ?></td>
						<td>
							<a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
							<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
						</td>
					</tr>
				<?php } ?>
		<?php } ?>	
		
	</table>
</body>
</html>