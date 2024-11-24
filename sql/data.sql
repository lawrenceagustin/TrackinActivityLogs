create table applicant_data (
	id INT AUTO_INCREMENT PRIMARY KEY,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
  nationality VARCHAR(255),
  age VARCHAR(10),
  gender VARCHAR(255),
	email VARCHAR(255),
	contact_no VARCHAR(50),
	home_address VARCHAR(255),
  position VARCHAR(255),
  location_pref VARCHAR(255),
	date_added TIMESTAMP 
);

CREATE TABLE user_accounts (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	password TEXT,
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE activity_logs (
	activity_log_id INT AUTO_INCREMENT PRIMARY KEY,
	operation VARCHAR(255),
	id INT,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
  nationality VARCHAR(255),
  age VARCHAR(10),
  gender VARCHAR(255),
	email VARCHAR(255),
	contact_no VARCHAR(50),
	home_address VARCHAR(255),
  position VARCHAR(255),
  location_pref VARCHAR(255),
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);