<?php

// set the connection for database and php

	class MyDB extends SQLite3 {
		function __construct() {
			$this -> open('reservation.db');
		}
	}
	//$db = new SQLite3('reservation.db');
	
	function insertUser($name, $mailing, $billing, $points, $payment, $email, $username, $password) {	
		$db = new MyDB();
		if (!$db) {
			echo $db -> lastErrorMsg();
		}
		
		$statement = $db->prepare("INSERT INTO users (name, mailing_address, billing_address, points, payment_method, email, username, password)
			VALUES (:name, :mailing, :billing, :points, :payment, :email, :username, :password);");
			
		$statement->bindValue(':name', $name);
		$statement->bindValue(':mailing', $mailing);
		$statement->bindValue(':billing', $billing);
		$statement->bindValue(':points', $points);
		$statement->bindValue(':payment', $payment);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $password);
		
		$result = $statement->execute();
		$db->close();
	}
	
	function insertReservation($preferred_diner_id, $date, $time, $name, $phone_num, $email, $num_of_guests, $tables, $payment_method) {	
		$db = new MyDB();
		if (!$db) {
			echo $db -> lastErrorMsg();
		}
		
		$statement = $db->prepare("INSERT INTO reservations (preferred_diner_id, date, time, name, phone_num, email, num_of_guests, tables, payment_method)
			VALUES (:preferred_diner_id, :date, :time, :name, :phone_num, :email, :num_of_guests, :tables, :payment_method);");
			
		$statement->bindValue(':preferred_diner_id', $preferred_diner_id);
		$statement->bindValue(':date', $date);
		$statement->bindValue(':time', $time);
		$statement->bindValue(':name', $name);
		$statement->bindValue(':phone_num', $phone_num);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':num_of_guests', $num_of_guests);
		$statement->bindValue(':tables', $tables);
		$statement->bindValue(':payment_method', $payment_method);
	
		$result = $statement->execute();
		$db->close();
	}
	
	function insertTables($table_id, $num_of_seats) {	
		$db = new MyDB();
		if (!$db) {
			echo $db -> lastErrorMsg();
		}
		
		$statement = $db->prepare("INSERT INTO tables (table_id, num_of_seats)
			VALUES (:table_id, :num_of_seats);");
			
		$statement->bindValue(':table_id', $table_id);
		$statement->bindValue(':num_of_seats', $num_of_seats);
		
		$result = $statement->execute();
		$db->close();
	}
	
	function insertHighTrafficDays($date, $label) {	
		$db = new MyDB();
		if (!$db) {
			echo $db -> lastErrorMsg();
		}
		
		$statement = $db->prepare("INSERT INTO high_traffic_days (date, label)
			VALUES (:date, :label);");
			
		$statement->bindValue(':date', $date);
		$statement->bindValue(':label', $label);
		
		$result = $statement->execute();
		$db->close();
		}
		
	function getUser($username, $password) {	
		$db = new MyDB();
		if (!$db) {
			echo $db -> lastErrorMsg();
		}
		
		$statement = $db->prepare("SELECT name FROM users WHERE username = :username and password = :password");
		
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $password);
		
		$result = $statement->execute();
		$db->close();
		return $result;
	}
	
	//Returns true if $result is empty.
	function emptyResult($result) {
		if ($result->fetchArray() == false) {
			$result->reset();
			return true;
		} else {
			$result->reset();
			return false;
		}
	}
	
	//Returns true if Username is in database
	function doesUserExist($username) {
		$db = new MyDB();
		if (!$db) {
			echo $db -> lastErrorMsg();
		}
		$statement = $db->prepare("SELECT * FROM users WHERE username = :username");
		$statement->bindValue(':username', $username);
		$result = $statement->execute();
		
		if (emptyResult($result)) {
			$db->close();
			return false;
		} else {
			$db->close();
			return true;
		}
	}
	
	/*$db = new MyDB();
	if (!$db) {
		echo $db -> lastErrorMsg();
	}
	$statement = $db->prepare("SELECT * FROM users");
	$result = $statement->execute();
	
	if (emptyResult($result)) {
		echo "empty\n";
	} else {
		echo "not empty \n";
	}
	
	if (doesUserExist('Guest')) {
		echo "Exists \n";
	} else {
		echo "Does not exist\n";
	}
		
	while($row = $result->fetchArray()) {
	  header('Content-type: text/plain');
      echo "preferred_diner_id = ". $row['preferred_diner_id'] . "\n";
      echo "name = ". $row['name'] ."\n";
      echo "mailing_address = ". $row['mailing_address'] ."\n";
      echo "billing_address = ".$row['billing_address'] ."\n";
	  echo "points = ". $row['points'] . "\n";
      echo "payment_method = ". $row['payment_method'] ."\n";
      echo "email = ". $row['email'] ."\n";
      echo "username = ".$row['username'] ."\n";
	  echo "password = ".$row['password'] ."\n\n";
   }
	
	//$statement = $db->prepare("DELETE FROM users WHERE preferred_diner_id = 1");
	//$result = $statement->execute();
	
	$db->close();*/

?>


