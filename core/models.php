<?php

require_once 'dbConfig.php';

function getAllApplicant($pdo) {
	$sql = "SELECT * FROM applicant_data 
			ORDER BY first_name ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getApplicantByID($pdo, $id) {
	$sql = "SELECT * from applicant_data WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function searchForAApplicant ($pdo, $searchQuery) {
	// Check if the search query is numeric
	$isNumeric = is_numeric($searchQuery);

	if ($isNumeric) {
			// If the search query is numeric, search by age
			$sql = "SELECT * FROM applicant_data WHERE age = ?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$searchQuery]);
	} else {
			// If the search query is not numeric
			$sql = "SELECT * FROM applicant_data WHERE 
							BINARY CONCAT(first_name, last_name, nationality, gender, email, 
														contact_no, home_address, position, location_pref, date_added) 
							LIKE ?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(["%" . $searchQuery . "%"]);
	}
	
	return $stmt->fetchAll();
}

//insert applicant
function insertNewApplicant($pdo, $first_name, $last_name, $nationality, 
	$age, $gender, $email, $contact_no, $home_address, $position, $location_pref) {

	$response = array();
	$sql = "INSERT INTO applicant_data 
			(
				first_name,
				last_name,
				nationality,
				age,
				gender,
				email,
				contact_no,
				home_address,
        position,
        location_pref
			)
			VALUES (?,?,?,?,?,?,?,?,?,?)
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([
		$first_name, $last_name, $nationality, 
	  $age, $gender, $email, $contact_no, 
    $home_address, $position, $location_pref
	]);

	if ($executeQuery) {
		$findInsertedItemSQL = "SELECT * FROM applicant_data ORDER BY date_added DESC LIMIT 1";
		$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
		$stmtfindInsertedItemSQL->execute();
		$getApplicantByID = $stmtfindInsertedItemSQL->fetch();

		$insertAnActivityLog = insertAnActivityLog($pdo, "INSERT", $getApplicantByID['id'], 
		$getApplicantByID['first_name'], $getApplicantByID['last_name'], 
		$getApplicantByID['nationality'], $getApplicantByID['age'],$getApplicantByID['gender'],
		$getApplicantByID['email'],$getApplicantByID['contact_no'],$getApplicantByID['home_address'],
		$getApplicantByID['position'],$getApplicantByID['location_pref'], $_SESSION['username']);

		if ($insertAnActivityLog) {
			$response = array(
				"status" =>"200",
				"message"=>"Applicant addedd successfully!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
		
	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"Insertion of data failed!"
		);

	}

	return $response;
		return true;
	}


//updateApplicant
function editApplicant($pdo, $first_name, $last_name, $nationality, $age, $gender, $email, $contact_no, $home_address, $position, $location_pref, $id) {
	$sql = "UPDATE applicant_data SET first_name = ?, last_name = ?, nationality = ?, age = ?, gender = ?, email = ?, 
					contact_no = ?, home_address = ?, position = ?, location_pref = ? WHERE id = ?";

	$stmt = $pdo->prepare($sql);
	return $stmt->execute([$first_name, $last_name, $nationality, $age, $gender, $email, $contact_no, $home_address, $position, $location_pref, $id]);
}

//delete applicant
function deleteApplicant($pdo, $id) { 
	$response = array();
	$sql = "SELECT * FROM applicant_data WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);
	$getApplicantByID = $stmt->fetch();

	if ($getApplicantByID) {
		$deleteSql = "DELETE FROM applicant_data WHERE id = ?";
		$deleteStmt = $pdo->prepare($deleteSql);
		$deleteQuery = $deleteStmt->execute([$id]);

		if ($deleteQuery) {
			$insertAnActivityLog = insertAnActivityLog($pdo, "DELETE", $getApplicantByID['id'], 
			$getApplicantByID['first_name'], $getApplicantByID['last_name'], 
			$getApplicantByID['nationality'], $getApplicantByID['age'], 
			$getApplicantByID['gender'], $getApplicantByID['email'],
			$getApplicantByID['contact_no'], $getApplicantByID['home_address'],
			$getApplicantByID['position'], $getApplicantByID['location_pref']);
			
			$response = array(
				"status" => "200",
				"message" => "Deleted the applicant successfully and activity log inserted!"
			);
		} else {
			$response = array(
				"status" => "400",
				"message" => "Failed to delete the applicant!"
			);
		}
	} else {
		$response = array(
			"status" => "404",
			"message" => "Applicant not found!"
		);
	}

	return $response;
}




//new

function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_accounts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function insertAnActivityLog($pdo, $operation, $id, $first_name, $last_name, $nationality, 
$age, $gender, $email, $contact_no, $home_address, $position, $location_pref) {

    $sql = "INSERT INTO activity_logs (operation, id, first_name, last_name, nationality, age, gender, email, 
                                        contact_no, home_address, position, location_pref, date_added) 
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?, NOW())";

    $stmt = $pdo->prepare($sql);

    $executeQuery = $stmt->execute([$operation, $id, $first_name, $last_name, $nationality, 
                                    $age, $gender, $email, $contact_no, $home_address, $position, $location_pref]);
    return $executeQuery;
}


function getAllActivityLogs($pdo) {
	$sql = "SELECT * FROM activity_logs";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		return $stmt->fetchAll();
	}
}

?>


