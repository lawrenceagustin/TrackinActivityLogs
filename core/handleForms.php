<?php  

require_once 'dbConfig.php';
require_once 'models.php';

//new insertApplicant
if (isset($_POST['insertApplicantBtn'])) {
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$nationality = trim($_POST['nationality']);
	$age = trim($_POST['age']);
	$gender = trim($_POST['gender']);
	$email = trim($_POST['email']);
	$contact_no = trim($_POST['contact_no']);
	$home_address = trim($_POST['home_address']);
	$position = trim($_POST['position']);
	$location_pref = trim($_POST['location_pref']);

	if (!empty($first_name) && !empty($last_name) && !empty($nationality)
			&& !empty($age)&& !empty($gender)&& !empty($email)
			&& !empty($contact_no)&& !empty($home_address)&& !empty($position)
			&& !empty($location_pref)){

		$insertNewApplicant = insertNewApplicant($pdo, $first_name, $last_name, $nationality, 
		$age, $gender, $email, $contact_no, $home_address, $position, $location_pref, $_SESSION['username']);

		$_SESSION['status'] =  $insertNewApplicant['status']; 
		$_SESSION['message'] =  $insertNewApplicant['message']; 
		header("Location: ../index.php");
		exit;
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../index.php");
		exit;
	}

}

//new editApplicant
if (isset($_POST['editApplicantBtn'])) {
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$nationality = trim($_POST['nationality']);
	$age = trim($_POST['age']);
	$gender = trim($_POST['gender']);
	$email = trim($_POST['email']);
	$contact_no = trim($_POST['contact_no']);
	$home_address = trim($_POST['home_address']);
	$position = trim($_POST['position']);
	$location_pref = trim($_POST['location_pref']);
	$id = $_GET['id'];

	$updateResult = editApplicant($pdo, $first_name, $last_name, $nationality, $age, $gender, $email, $contact_no, $home_address, $position, $location_pref, $id);

	if ($updateResult) {
		
		$operation = "UPDATED";
		insertAnActivityLog($pdo, $operation, $id, $first_name, $last_name, $nationality, 
												$age, $gender, $email, $contact_no, $home_address, $position, $location_pref);

		$_SESSION['message'] = "Applicant updated successfully!";
		$_SESSION['status'] = "success";
		header("Location: ../index.php");
		exit;
} else {
		$_SESSION['message'] = "Failed to update applicant!";
		$_SESSION['status'] = "error";
		header("Location: edit.php?id=" . $id);
		exit;
}
}


if (isset($_POST['deleteApplicantBtn'])) {
	$id = $_GET['id'];

	if (!empty($id)) {
		$deleteApplicant = deleteApplicant($pdo, $id);
		$_SESSION['message'] = $deleteApplicant['message'];
		$_SESSION['status'] = $deleteApplicant['status'];
		header("Location: ../index.php");
	}
}

if (isset($_GET['searchBtn'])) {
	$searchForAUser = searchForAApplicant($pdo, $_GET['searchInput']);
	foreach ($searchForAUser as $row) {
		echo "<tr> 
          <td>{$row['first_name']}</td>
					<td>{$row['last_name']}</td>
          <td>{$row['nationality']}</td>
          <td>{$row['age']}</td>
          <td>{$row['gender']}</td>
          <td>{$row['email']}</td>
          <td>{$row['contact_no']}</td>
          <td>{$row['home_address']}</td>
          <td>{$row['position']}</td>
          <td>{$row['location_pref']}</td>
			  </tr>";
	}
}

//new

if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && 
		!empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, 
				password_hash($password, PASSWORD_DEFAULT));

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = "400";
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = "400";
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);

		if ($loginQuery['status'] == '200') {
			$usernameFromDB = $loginQuery['userInfoArray']['username'];
			$passwordFromDB = $loginQuery['userInfoArray']['password'];

			if (password_verify($password, $passwordFromDB)) {
				$_SESSION['username'] = $usernameFromDB;
				header("Location: ../index.php");
			}
		}

		else {
			$_SESSION['message'] = $loginQuery['message'];
			$_SESSION['status'] = $loginQuery['status'];
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure no input fields are empty";
		$_SESSION['status'] = "400";
		header("Location: ../login.php");
		exit;
	}
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
	exit;
}
?>